<?php
    namespace App\Services;

    use App\Models\User;
    use App\Models\Payment;
    use Illuminate\Support\Facades\Mail;
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
                $paid = 0;
                Stripe::setApiKey(env('STRIPE_SECRET'));
                if(!$user->hasPaymentMethod()) {
                    $this->sendEmailToUser($user);
                    $this->sendEmailToOwner($user);
                } else {
                    $customer = [];
                    try {
                        $customer = \Stripe\Customer::retrieve($user->stripe_id);
                        $amount = $user->salon->fee;
                        Charge::create(array(
                            'amount' => $amount,
                            'currency' => 'jpy',
                            'customer' => $customer->id
                        ));
                        $paid = $amount;
                    } catch( \Exception $e ){
                        // send email to user and owner
                        echo('エラー！');
                        $this->sendEmailToUser($user);
                        $this->sendEmailToOwner($user);
                        $paid = null;
                        echo(1);
                    }
                }
                $yearMonth = (int)(date("Y").date("m"));
                echo($user->id.' '.$yearMonth);
                Payment::insert([
                    'amount' => $paid,
                    'salon_id' => $user->salon->id,
                    'user_id' => $user->id,
                    'payment_for' => $yearMonth,
                    'created_at' => now()
                ]);
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
