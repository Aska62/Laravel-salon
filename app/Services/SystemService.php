<?php
    namespace App\Services;

    use App\Models\Owner;
    use App\Models\Salon;
    use App\Models\User;
    use App\Models\Payment;
    use DB;
    use Illuminate\Http\Request;
    use Illuminate\Pagination\Paginator;

    class SystemService
    {
        /**
         * Get all active owner info
         *
         * @return App\Models\Owner
         */
        public function getAllOwners() {
            return Owner::whereNull('deleted_at')->with('salon')->get();
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
         * Get monthly payment history - yearMonth, users count, total amount
         *
         * @return App\Models\Payments
         */
        public function getMonthlyPayment() {
            return Payment::select(DB::raw('payment_for, COUNT(id) as total_users, SUM(amount) as total_amount'))
                ->groupBy('payment_for')
                ->orderBy('payment_for', 'desc')
                ->limit(12)
                ->get();
        }

        /**
         * Output salon info to CSV
         *
         *
         */
        public function output() {
            $filename = 'info-'.date('YmdHis').'.csv';
            $header = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename='.$filename,
                'Pragma' => 'no-cache',
            ];

            $createCsv = function($filename) {
                $head = [
                    'サロンID',
                    'サロン名',
                    'オーナー名',
                    'Facebook URL',
                    'ユーザーID',
                    'ユーザー名',
                    date('Y').'年'.date('m').'月決済金額'
                ];

                $users = User::leftJoin('payments', function ($join) {
                    $join->on('users.id', '=', 'payments.user_id')
                        ->where('payments.payment_for', date('Ym'));
                    })
                    ->whereNull('users.deleted_at')
                    ->orWhere('users.deleted_at', '>=', strtotime(date('Ym').'01 00:00:00'))
                    ->orderBy('users.salon_id', 'asc')
                    ->orderBy('payments.amount')
                    ->orderBy('users.id', 'asc')
                    ->get();

                // ddd($users);
                $info = [];

                foreach($users as $user) {
                    // var_dump($user->payment['amount']);die();
                    $info[] = [
                        'salon_id' => $user->salon_id?? 'NULL',
                        'salon_name' => $user->getSalon()->name?? 'NULL',
                        'owner_name' => $user->getSalon()->ownerName()[0]->owner_name,
                        'facebook' => $user->getSalon()->facebook?? 'NULL',
                        'userId' => $user->id,
                        'userName' => $user->name,
                        'payment' => $user->amount?? 'FAIL'
                    ];
                }
                // var_dump($user->salon()->ownerName()[0]->owner_name);
                // ddd($info);
                // exit();
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
            };
            // ddd($createCsv($filename));
            return response()->make($createCsv($filename), 200, $header)->send();
        }
    }
