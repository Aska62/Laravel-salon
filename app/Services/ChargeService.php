<?php
    namespace App\Services;

    use App\Models\User;
    use App\Models\Payment;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Rule;
    use Illuminate\Support\Facades\Mail;
    use Laravel\Cashier\Cashier;
    use Stripe\Stripe;
    use Stripe\Charge;

    class ChargeService
    {
        /**
         * Charge monthly payment to all existing users
         *
         * @return void
         */
        public function chargeMonthlyPayment() {
            $users = User::whereNull('deleted_at')
                ->whereNull('pm_type')
            // ->where('users.created_at', '<', strtotime(date('Ym').'01 00:00:00'))
                ->get();

            foreach($users as $user) {
                Stripe::setApiKey(env('STRIPE_SECRET'));
                if(!$user->hasPaymentMethod()) {
                    $this->sendEmailToUser($user);
                    $this->sendEmailToOwner($user);
                } else {
                    $customer;
                    try {
                        $customer = \Stripe\Customer::retrieve($user->stripe_id);
                    } catch (\Stripe\Exception\InvalidRequestException $e) {
                        $this->sendEmailToUser($user);
                        $this->sendEmailToOwner($user);
                    } catch ( Exception $e ){
                        // send email to user and owner
                        $this->sendEmailToUser($user);
                        $this->sendEmailToOwner($user);
                    }
                    try {
                        $amount = $user->salon->fee;
                        $charge = Charge::create(array(
                            'amount' => $amount,
                            'currency' => 'jpy',
                            'customer' => $customer->id
                        ));
                        // update pament table
                        $yearMonth = (int)(date("Y").date("m"));
                        Payment::insert([
                            'amount' => $amount,
                            'salon_id' => $user->salon->id,
                            'user_id' => $user->id,
                            'payment_for' => $yearMonth,
                            'created_at' => now()
                        ]);
                    } catch ( Exception $e ){
                        // send email to user and owner
                        $this->sendEmailToUser($user);
                        $this->sendEmailToOwner($user);
                    }
                }
            }
        }

        /**
         * Send email to user if payment error occurs
         *
         * @param App\Models\User $user
         */
        public function sendEmailToUser(User $user) {
            Mail::send('emails.errorMsgToUser', ['user' => $user], function($message) use ($user) {
                $message->to($user->email)
                    ->subject($user->salon->name." ".date('m')."月会費の支払いが完了できませんでした")
                    ->from(config('mail.from.address'));
            });
        }

        /**
         * Send email to owner if payment error occurs
         *
         * @param App\Models\User $user
         */
        public function sendEmailToOwner(User $user) {
            Mail::send('emails.errorMsgToOwner', ['user' => $user], function($message) use ($user){
                $message->to($user->salon->owner->email)
                    ->subject($user->salon->name." ".date('m')."月会費の支払いについて")
                    ->from(config('mail.from.address'));
            });
        }
    }
