<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SalonResource;
use App\Models\Salon;
use App\Models\User;

class UserResource extends JsonResource
{
    public static $wrap = 'user';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $salons = [];
        if($request->user_name) {
            $salon_ids = [];
            $pat = '%' . addcslashes($request->user_name, '%_\\') . '%';
            $users = User::where('name', 'LIKE', $pat)
                ->whereNull('deleted_at')
                ->get();
            foreach($users as $user) {
                array_push($salon_ids, $user->salon->id);
            }
            $salons = Salon::where('owner_id', $this->id)
                ->whereNull('deleted_at')
                ->whereIn('id', $salon_ids)
                ->get();
        } else {
            $salons = Salon::where('owner_id', $this->id)
                ->whereNull('deleted_at')
                ->get();
        }

        return [
            'owner_id' => $this->id,
            'owner_name' => $this->owner_name,
            'salon_info' => SalonResource::collection($salons)
        ];
    }
}
