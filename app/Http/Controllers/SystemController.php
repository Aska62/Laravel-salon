<?php

namespace App\Http\Controllers;

use App\Services\SystemService;
use App\Services\UsersService;

class SystemController extends Controller
{
    protected $request;
    protected $systemSer;
    protected $usersSer;

    public function __construct(SystemService $systemSer, UsersService $usersSer) {
        $this->systemSer = $systemSer;
        $this->usersSer = $usersSer;
    }

    /**
     * Display system top - onwer list
     *
     * @return view
     */
    public function systemTop() {
        return view('system.top.index', [
            'owners' => $this->systemSer->getAllOwners()
        ]);
    }

    /**
     * Display salon list
     *
     * @return view
     */
    public function listSalons() {
        ddd($this->systemSer->getOwnerByName('丸山権三'));
        return view('system.salons.index', [
            'salons' => $this->usersSer->getAllSalons()
        ]);
    }

    /**
     * Display user list
     *
     * @return view
     */
    public function listUsers() {
        return view('system.users.index', [
            'users' => $this->systemSer->getAllUsers(),
            'activeUsers' => $this->systemSer->getActiveUsers(),
            'totalUserCount' => $this->systemSer->getUserCount()
        ]);
    }

    /**
     * Display payment history
     *
     * @return view
     */
    // public function paymentHistory() {
    //     return view('system.payments.index', [
    //         'payments' => $this->systemSer->getMonthlyPayment()
    //     ]);
    // }

    /**
     * Output info to CSV
     *
     * @return response
     */
    public function outputCSV() {
        $filename = 'info-'.date('YmdHis').'.csv';
        $header = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename='.$filename,
            'Pragma' => 'no-cache',
        ];
        return response()->streamDownload(function() use ($filename) {
            $this->systemSer->createCsv();
            },
            $filename,
            $header
        );
    }

}
