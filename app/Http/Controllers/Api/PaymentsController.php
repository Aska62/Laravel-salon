<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SystemService;
use App\Http\Resources\PaymentCollection;

class PaymentsController extends Controller
{
    protected $systemSer;

    /**
     * OwnersController constructor.
     *
     * @param SystemService $systemSer
     */
    public function __construct(SystemService $systemSer) {
        $this->systemSer = $systemSer;
    }

    /**
     * List users
     *
     * @param Request $request
     * @return view
     */
    public function index(Request $request) {
        if($request->owner_name) {
            return new PaymentCollection($this->systemSer->getOwnerByName($request->owner_name));
        } elseif($request->user_name) {
            return new PaymentCollection($this->systemSer->getOwnersByUserName($request->user_name));
        } else {
            return new PaymentCollection($this->systemSer->getPaginatedOwners());
        }
    }

}
