<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SystemService;
use App\Services\OwnersService;
use App\Http\Requests\SalonRequest;
use App\Http\Resources\SalonResource;

class SalonsController extends Controller
{
    protected $systemSer;
    protected $ownersSer;

    /**
     * OwnersController constructor.
     *
     * @param SystemService $systemSer
     */
    public function __construct(SystemService $systemSer, OwnersService $ownersSer) {
        $this->systemSer = $systemSer;
        $this->ownersSer = $ownersSer;
    }

    // public function show($salon_id) {
    //     return new SalonResource($this->systemSer->getSalonInfo($salon_id));
    // }

    /**
     * Register new salon
     *
     * @param SalonRequest $request
     */
    public function store(SalonRequest $request) {
        $data = $request->except('_token');
        $owner_id = -1;

        // If the owner is new, register
        if($this->ownersSer->isNewOwner($request->email)) {
            $owner = $this->ownersSer->storeOwner($request->all());
            $owner_id = $owner->id;
            if(!($owner_id >= 0)) {
                return response()->json(
                    [
                        'status' => Config('define.result.NG'),
                        'message' => Config('define.result.serverError.message'),
                    ],
                    Config('define.result.serverError.status')
                );
            }
        } else {
            $owner_id = $this->ownersSer->findOwnerIdByEmail($data['email']);
        }

        // Register a new salon
        // $result = $this->ownersSer->storeSalonWoImage($request, $owner_id);
        $result = $this->ownersSer->storeSalon($request, $owner_id);

        // Return response
        $resultConf = $result ? 'define.result.success' : 'define.result.serverError';
        return response()->json(
            [
                'status' => $result ? Config('define.result.OK') : Config('define.result.NG'),
                'message' => Config($resultConf.'.message'),
            ],
            Config($resultConf.'.status')
        );
    }
}
