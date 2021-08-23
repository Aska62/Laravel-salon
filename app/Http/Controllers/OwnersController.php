<?php

namespace App\Http\Controllers;

use App\Services\OwnersService;
use Illuminate\Http\Request;

class OwnersController extends Controller
{
    protected $request;
    protected $ownersSer;

    public function __construct(OwnersService $ownersSer) {
        $this->ownersSer = $ownersSer;
    }

    /**
     * Display home
     *
     * @return view
     */
    public function ownerHome(Request $request) {
        $email = $request->email;
        $salons = [];
        if($email) {
            $salons = $this->ownersSer->searchSalons($email);
        }
        return view('owner.ownerHome.index', [
            'email' => $email,
            'salons' => $salons
        ]);
    }

    /**
     * Salon registration page
     *
     * @return view
     */
    public function create() {
        return view('owner.create.index');
    }

    /**
     * Register owner and salon
     *
     * @return view
     */
    public function addSalon(Request $request) {
        $this->ownersSer->validate($request);
        if($this->ownersSer->isNewOwner($request->email)) {
            $this->ownersSer->storeOwner($request);
        }
        $owner_id = $this->ownersSer->findOwnerIdByEmail($request->email);
        $this->ownersSer->storeSalon($request, $owner_id);

        return redirect()->route('owner.thanks');
    }

    /**
     * Display thanks after salon registration
     *
     * @return view
     */
    public function success() {
        return view('owner.success.index');
    }

}