<?php

namespace App\Http\Controllers;

use App\Services\OwnersService;
use App\Services\ChargeService;
use App\Http\Requests\SalonRequest;
use Illuminate\Http\Request;

class OwnersController extends Controller
{
    protected $request;
    protected $ownersSer;
    protected $chargeSer;

    public function __construct(OwnersService $ownersSer, ChargeService $chargeSer) {
        $this->ownersSer = $ownersSer;
        $this->chargeSer = $chargeSer;
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
            if(!$salons) {
                return redirect()
                    ->route('owner.home')
                    ->with('message', 'このアドレスに該当するサロンはありません。');
            }
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
    public function addSalon(SalonRequest $request) {
        $data = $request->except('_token');
        if($this->ownersSer->isNewOwner($data['email'])) {
            $this->ownersSer->storeOwner($data);
        }
        $owner_id = $this->ownersSer->findOwnerIdByEmail($data['email']);
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
