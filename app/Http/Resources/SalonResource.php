<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Models\User;

class SalonResource extends JsonResource
{
    public static $wrap = 'salon';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $users = [];
        if($request->user_name) {
            $pat = '%' . addcslashes($request->user_name, '%_\\') . '%';
            $users = User::select('id', 'name')
                ->where('salon_id', $this->id)
                ->where('name', 'LIKE', $pat)
                ->whereNull('deleted_at')
                ->get();
        } else {
            $users = User::select('id', 'name')
                ->where('salon_id', $this->id)
                ->whereNull('deleted_at')
                ->get();
        };

        return [
            'salon_id' => $this->id,
            'salon_name' => $this->name,
            'salon_fb' => $this->facebook,
            'salon_capacity' => $this->max_members,
            'salon_members' => $this->countUsers(),
            'user_info' => $users
        ];
    }
}
