<?php
    namespace App\Services;

    use App\Models\User;
    use App\Models\Salon;
    use App\Models\Payment;
    use Illuminate\Http\Request;
    use Illuminate\Pagination\Paginator;
    use Laravel\Cashier\Cashier;
    use Stripe\Stripe;
    use Stripe\Charge;

    class UsersService
    {
        public function boot(){
            Cashier::useCustomerModel(User::class);
        }

        /**
         * Get all available salons. Order: from new to old
         *
         * @return App\Models\Salon
         */
        public function getAllSalons() {
            Paginator::useBootstrap();
            return Salon::whereNull('deleted_at')
                ->with('owner')
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        }

        /**
         * Get salon info by id
         *
         * @param Int $salon_id
         *
         * @return App\Models\Salon
         */
        public function getSalonById(Int $salon_id) {
            return Salon::findOrFail($salon_id);
        }

        /**
         * Check if the user is new to the salon
         *
         * @param App\Models\Salon $salon String $user_email
         *
         * @return Boolean
         */
        public function isNewUser(Salon $salon, String $user_email) {
            $users = $salon->getAllUsers();
            foreach ($users as $user) {
                if ($user->email == $user_email) {
                    return false;
                }
            }
            return true;
        }

        /**
         * Check if the user is not the salon owner
         *
         * @param App\Models\Salon $salon String $user_email
         *
         * @return Boolean
         */
        public function isOwner(Salon $salon, String $user_email) {
            if ($salon->owner->email == $user_email) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Make an INITIAL payment
         *
         * @param Request $request
         * @return Stripe\Customer
         */
        public function pay(Request $request) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $customer = \Stripe\Customer::create([
                'name' => $request->user_name,
                'email' => $request->user_email,
                'source'=> $request->stripeToken
            ]);
            $salon = $this->getSalonById($request->salon_id);
            $charge = Charge::create(array(
                'amount' => $salon->fee,
                'currency' => 'jpy',
                'customer'=> $customer->id
            ));

            return $customer;
        }

        /**
         * Register news user to db
         *
         * @param Request $request
         * @return App\Models\User $user
         */
        public function registerUser(Request $request, $customer) {
            $user = User::create([
                'name' => $request->user_name,
                'email' => $request->user_email,
                'salon_id' => $request->salon_id,
                'stripe_id' => $customer->id,
                'created_at' => now()
            ]);
            return $user;
        }

        /**
         * Register new payment to db
         *
         * @param Request $request
         *
         */
        public function registerPayment(Request $request) {
            $yearMonth = (int)(date("Y").date("m"));
            $user = User::where('email', $request->user_email)
                ->where('salon_id', $request->salon_id)
                ->whereNull('deleted_at')
                ->firstOrFail();
            $salon = $this->getSalonById($request->salon_id);
            Payment::insert([
                'amount' => $salon->fee,
                'salon_id' => $salon->id,
                'user_id' => $user->id,
                'payment_for' => $yearMonth,
                'created_at' => now()
            ]);
        }

        /**
         * Find user by id
         *
         * @param int $user_id
         *
         * @return App\Models\User
         */
        public function getUserById($user_id) {
            return User::where('id', $user_id)
                ->firstOrFail();
        }

        /**
         * Get owner info salon id
         *
         * @param String salon_id
         *
         * @return App\Models\Owner
         */
        public function getOwnerBySalonId($salon_id) {
            $salon = $this->getSalonById($salon_id);
            return $salon->owner;
        }
    }

