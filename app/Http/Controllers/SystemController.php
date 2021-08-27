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
     * @return response
     */
    public function outputCSV(Request $request) {
        $filename = 'info-'.date('YmdHis').'.csv';
        $header = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename='.$filename,
            'Pragma' => 'no-cache',
        ];
        // return response()->make($this->systemSer->createCsv($filename), 200, $header);
        // return response()->streamDownload($this->systemSer->createCsv($filename), $filename, $header);
        return response()->streamDownload(function() use ($filename) {
            $this->systemSer->createCsv($filename);
            },
            $filename,
            $header
        );
    }

}
