<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OwnerCollection;
use App\Http\Resources\OwnerResource;
use App\Services\SystemService;

class OwnersController extends Controller
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
     * List owners
     *
     * @param Request $request
     * @return view
     */
    public function index(Request $request)
    {
        // クエリパラメータでowner_nameが渡されたら、該当オーナーの個別情報を表示
        if($request->owner_name) {
            return new OwnerCollection($this->systemSer->getOwnerByName($request->owner_name));
        }
        // クエリパラメータがなければ、オーナー一覧表示
        return new OwnerCollection($this->systemSer->getPaginatedOwners());
    }

    /**
     * Show owner info
     *
     * @return OwnerResource
     */
    public function show($owner_id)
    {
        return new OwnerResource($this->systemSer->getOwnerDetail($owner_id));
    }
}
