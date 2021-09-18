<?php
    namespace App\Services;

    use App\Models\Owner;
    use App\Models\User;
    use App\Models\Salon;
    use Illuminate\Pagination\Paginator;
    class SystemService
    {
        /**
         * Get all active owner info
         *
         * @return App\Models\Owner
         */
        public function getAllOwners() {
            return Owner::whereNull('deleted_at')
                ->with('salon')
                ->get();
        }

        /**
         * Get paginated active owners
         *
         * @return App\Models\Owner
         */
        public function getPaginatedOwners() {
            return Owner::whereNull('deleted_at')
                ->paginate(10);
        }
        /**
         * Get active owners by User Name
         *
         * @param Int $user_name
         * @return App\Models\Owner
         */
        public function getOwnersByUserName($user_name) {
            $users = $this->getUserByName($user_name);
            $owner_ids = [];
            foreach($users as $user) {
                array_push($owner_ids, $user->salon->owner->id);
            }

            return Owner::whereIn('id', $owner_ids)->get();
        }

        /**
         * Get owner detail
         *
         * @param int $owner_id
         * @return App\Models\Owner
         */
        public function getOwnerDetail($owner_id) {
            return Owner::findOrFail($owner_id);
        }

        /**
         * Get owner info by name
         *
         * @param String $owner_name
         * @return App\Models\Onwer
         */
        public function getOwnerByName($owner_name) {
            $pat = '%' . addcslashes($owner_name, '%_\\') . '%';
            return Owner::where('owner_name', 'LIKE', $pat)
                ->get();
        }

        /**
         * Get user info by name
         *
         * @param String $user_name
         * @return App\Models\User
         */
        public function getUserByName($user_name) {
            $pat = '%' . addcslashes($user_name, '%_\\') . '%';
            return User::where('name', 'LIKE', $pat)->get();
        }

        /**
         * Get all users with pagination
         *
         * @return App\Models\User
         */
        public function getAllUsers() {
            Paginator::useBootstrap();
            return User::with('salon')->paginate(20);
        }

        /**
         * Get total user count
         *
         * @return Int $userCount
         */
        public function getUserCount() {
            return User::count();
        }

        /**
         * Get all active users
         *
         * @return App\Models\User
         */
        public function getActiveUsers() {
            return User::whereNull('deleted_at')
                ->with('salon')
                ->get();
        }

        /**
         * Get detail salon info
         *
         * @param Int $salon_id
         * @return App\Models\Salon
         */
        public function getSalonInfo($salon_id) {
            return Salon::findOrFail($salon_id);
        }

        /**
         * Output salon info to CSV
         *
         * @param String $filename
         *
         */
        public function createCSV() {
            $head = [
                'サロンID',
                'サロン名',
                'オーナー名',
                'Facebook URL',
                'ユーザーID',
                'ユーザー名',
                date('Y').'年'.date('m').'月決済金額'
            ];

            $users = User::select('users.id as user_id', 'users.name', 'users.salon_id', 'payments.amount')
                ->leftJoin('payments', 'users.id', '=', 'payments.user_id')
                ->where('payments.payment_for', date('Ym'))
                ->where(function($query) {
                    $query->whereNull('users.deleted_at')
                        ->orWhere('users.deleted_at', '>=', strtotime(date('Ym').'01 00:00:00'));
                })
                ->orderBy('users.salon_id', 'asc')
                ->orderBy('amount')
                ->orderBy('user_id', 'asc')
                ->get();

            $info = [];

            foreach($users as $user) {
                $info[] = [
                    'salon_id' => $user->salon_id?? 'NULL',
                    'salon_name' => $user->salon->name?? 'NULL',
                    'owner_name' => $user->salon->owner->owner_name ?? 'NULL',
                    'facebook' => $user->salon->facebook?? 'NULL',
                    'userId' => $user->user_id,
                    'userName' => $user->name,
                    'payment' => $user->amount?? ''
                ];
            }

            $f = fopen('php://output', 'w');
            if($f) {
                mb_convert_variables('SJIS', 'UTF-8', $head);
                fputcsv($f, $head);
                foreach($info as $inf) {
                    mb_convert_variables('SJIS', 'UTF-8', $inf);
                    fputcsv($f, $inf);
                }
            }
            fclose($f);
        }
    }
