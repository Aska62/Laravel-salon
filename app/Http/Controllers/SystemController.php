<?php

namespace App\Http\Controllers;

use App\Services\SystemService;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    protected $request;
    protected $systemSer;

    public function __construct(SystemService $systemSer) {
        $this->systemSer = $systemSer;
    }

    /**
     * Display system top
     *
     * @return view
     */
    public function systemTop() {
        return view('system.top.index', [
            'owners' => $this->systemSer->getAllOwners()
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
    public function paymentHistory() {
        return view('system.payments.index', [
            'payments' => $this->systemSer->getMonthlyPayment()
        ]);
    }

    /**
     * Output owners info to CSV
     *
     * @return redirect
     */
    public function outputCSV(Request $request) {
        $this->systemSer->output($request->owners);
        return redirect()->route('system.top');
    }
}
