<?php

namespace App\Http\Controllers;

use App\Services\UsersService;
use App\Services\ChargeService;
use App\Http\Requests\UserRequest;
use App\Jobs\sendEmail;
use App\Jobs\SendEmailToOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    protected $request;
    protected $chargeSer;
    protected $userSer;
    protected $sendEmail;

    public function __construct(usersService $usersSer, ChargeService $chargeSer) {
        $this->usersSer = $usersSer;
        $this->chargeSer = $chargeSer;
    }

    /**
     * Display home
     *
     * @return view
     */
    public function home() {
        return view('user.home.index', [
            'salons' => $this->usersSer->getAllSalons()
        ]);
    }

    /**
     * Display salon detail
     *
     * @param Request $request
     *
     * @return view
     */
    public function detail(Request $request) {
        return view('user.detail.index', [
            'salon' => $this->usersSer->getSalonById($request->id)
        ]);
    }

    /**
     * Display salon entry page
     *
     * @param Request $request
     *
     * @return view
     */
    public function entry(Request $request) {
        return view('user.entry.index', [
            'salon' => $this->usersSer->getSalonById($request->id)
        ]);
    }

    /**
     * Validate user info and display payment page
     *
     * @param UserRequest $request
     *
     * @return view
     */
    public function payment(UserRequest $request) {
        // validate
        $data = $request->except('_token');

        // check if the email is unique to the salon
        $salon = $this->usersSer->getSalonById($request->salon_id);
        if($request->email) {
            $isNewUser = $this->usersSer->isNewUser($salon, $request->email);
            $isOwner = $this->usersSer->isOwner($salon, $request->email);
            if(!$isNewUser) {
                return back()
                    ->withInput()
                    ->with('message', 'このメールアドレスは登録済みです。');
            } elseif($isOwner) {
                return back()
                    ->withInput()
                    ->with('message', 'このアドレスはサロンオーナーと同一です。');
            }
        }

        return view('user.payment.index', [
            'salon' => $salon,
            'user_name' => $data['name'],
            'user_email' => $data['email'],
        ]);
    }

    /**
     * Handle payment and send emails
     *
     * @param Request $request
     *
     * @return redirect
     */
    public function submit(Request $request) {
        // Register as a Stripe custoer
        $customer = $this->usersSer->pay($request);

        // Register as a new salon member
        $user = $this->usersSer->registerUser($request, $customer);
        $this->usersSer->registerPayment($request);

        // Send emails to user and salon owner
        $owner = $this->usersSer->getOwnerBySalonId($request->salon_id);
        SendEmail::dispatch($user);
        SendEmailToOwner::dispatch($user);

        return redirect()->route('user.welcome', [
            'salon_name' => $this->usersSer->getSalonById($request->salon_id)->name,
            'user' => $user
        ]);
    }

    /**
     * Display welcome page
     *
     * @param Request $request
     * @return view
     */
    public function welcome(Request $request) {
        $user = $this->usersSer->getUserById($request->user);
        return view('user.welcome.index', [
            'salon_name' => $request->salon_name,
            'user' => $user->name
        ]);
    }
}
