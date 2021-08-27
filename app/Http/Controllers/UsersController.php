<?php

namespace App\Http\Controllers;

use App\Services\UsersService;
use App\Services\ChargeService;
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
            'salon' => $this->usersSer->getSalonByName($request->name)
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
     * @param Request $request
     *
     * @return view
     */
    public function payment(Request $request) {
        $this->usersSer->validateUser($request);
        return view('user.payment.index', [
            'salon' => $this->usersSer->getSalonById($request->salon_id),
            'user_name' => $request->name,
            'user_email' => $request->email,
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
        $yearMonth = (int)(date("Y").date("m"));
        $customer = $this->usersSer->pay($request);
        $this->usersSer->registerUser($request, $customer);
        $this->usersSer->registerPayment($request);

        $user = $this->usersSer->getUserByEmail($request->user_email, $request->salon_id);
        $owner = $this->usersSer->getOwnerBySalonId($request->salon_id);

        SendEmail::dispatch($user);
        SendEmailToOwner::dispatch($owner, $user);

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
            'user' => $user->name,
            // 'intent' => $user->createSetupIntent()
        ]);
    }

    /**
     * Registe payment method
     *
     * @param Request $request
     * @return view
     */
    public function addPaymentMethod(Request $request) {
        $user = $this->usersSer->getUserById($request->user_id);
        $user->updateDefaultPaymentMethod($request->payment_method);
        // $user->newSubscriptiuon('default', )
        return view('user.addPaymentMethod.index');
    }
}
