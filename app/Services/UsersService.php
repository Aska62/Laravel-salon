<?php
    namespace App\Services;

    use App\Models\User;
    use App\Models\Salon;
    use App\Models\Owner;
    use App\Models\Payment;
    use DB;

    use Illuminate\Http\Request;
    use Illuminate\Validation\Rule;
    use Illuminate\Support\Facades\Auth;
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
            return Salon::whereNull('deleted_at')
                ->with('owner')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        /**
         * Get salon info by id
         *
         * @param String $salon_id
         *
         * @return App\Models\Salon
         */
        public function getSalonById(String $salon_id) {
            return Salon::findOrFail($salon_id);
        }

        /**
         * Get salon info by name
         *
         * @param String $salon_name
         *
         * @return App\Models\Salon
         */
        public function getSalonByName(String $salon_name) {
            return Salon::where('name', $salon_name)->firstOrFail();
        }

        /**
         * Check if the user is new to the salon
         *
         * @param Array $salon String $user_email
         *
         * @return Boolean
         */
        public function isNewUser(Array $salon, String $user_email) {
            $users = $salon->user();
            foreach($users as $user) {
                if($user->email == $user_email) {
                    return false;
                } else {
                    return true;
                }
            }
        }

        /**
         * Check if the user is not the salon owner
         *
         * @param App/Models/Salon $salon String $user_email
         *
         * @return Boolean
         */
        public function isOwner(Array $salon, String $user_email) {
            if($salon->owner->email == $user_email) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Validate new user data
         *
         * @param Request $request
         *
         */
        public function validateUser(Request $request) {
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('users', 'email')
                        ->where('salon_id', $request->email)
                        ->whereNull('deleted_at'),
                    Rule::unique('owners', 'email')
                        ->where('id', $request->owner_id)
                ]
            ]);
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

            $charge = Charge::create(array(
                'amount' => $request->fee,
                'currency' => 'jpy',
                'customer'=> $customer->id
            ));

            return $customer;
        }

        /**
         * Register news user to db
         *
         * @param Request $request
         *
         */
        public function registerUser(Request $request, $customer) {
            $user = User::create([
                'name' => $request->user_name,
                'email' => $request->user_email,
                'salon_id' => $request->salon_id,
                'stripe_id' => $customer->id,
                'created_at' => now()
            ]);
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
            Payment::insert([
                'amount' => $request->fee,
                'salon_id' => $request->salon_id,
                'user_id' => $user->id,
                'payment_for' => $yearMonth,
                'created_at' => now()
            ]);
        }


        /**
         * Get user info by name and salon id
         *
         * @param String $user_email, $Int salon_id
         *
         * @return App\Models\User
         */
        public function getUserByEmail($user_email, $salon_id) {
            return User::where('email', $user_email)
                ->where('salon_id', $salon_id)
                ->whereNull('deleted_at')
                ->firstOrFail();
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
         * @return App/Models/Owner
         */
        public function getOwnerBySalonId($salon_id) {
            $salon = $this->getSalonById($salon_id);
            return $salon->owner;
        }
    }

