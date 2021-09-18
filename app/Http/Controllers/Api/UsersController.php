<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserRequest;
use App\Services\SystemService;
use App\Services\UsersService;
use App\Jobs\sendEmail;

class UsersController extends Controller
{
    protected $systemSer;
    protected $usersSer;

    /**
     * OwnersController constructor.
     *
     * @param SystemService $systemSer
     */
    public function __construct(SystemService $systemSer, UsersService $usersSer) {
        $this->systemSer = $systemSer;
        $this->usersSer = $usersSer;
    }

    /**
     * List users
     *
     * @param Request $request
     * @return view
     */
    public function index(Request $request) {
        if($request->owner_name) {
            return new UserCollection($this->systemSer->getOwnerByName($request->owner_name));
        } elseif($request->user_name) {
            return new UserCollection($this->systemSer->getOwnersByUserName($request->user_name));
        } else {
            return new UserCollection($this->systemSer->getPaginatedOwners());
        }
    }

    /**
     * Register new user
     *
     * @param UserRequest $request
     */
    public function store(UserRequest $request) {
        // Register new user
        $user = $this->usersSer->registerUserWoStripe($request);
        $resultConf = !empty($user) ? 'define.result.success' : 'define.result.serverError';

        // Send emails to user and salon owner
        if(!empty($user)) {
            SendEmail::dispatch($user);
        }

        return response()->json(
            [
                'status' => $user ? Config('define.result.OK') : Config('define.result.NG'),
                'message' => Config($resultConf.'.message'),
            ],
            Config($resultConf.'.status')
        );
    }

}
