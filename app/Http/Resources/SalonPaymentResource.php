<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\models\User;

class SalonPaymentResource extends JsonResource
{
    public static $wrap = 'salon_info';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $users = [];
        if($request->user_name) {
            $users = User::where('salon_id', $this->id)
                ->where('name', $request->user_name)
                ->whereNull('deleted_at')
                ->get();
        } else {
            $users = User::where('salon_id', $this->id)
                ->whereNull('deleted_at')
                ->get();
        }

        return [
            'salon_id' => $this->id,
            'salon_name' => $this->name,
            'salon_fb' => $this->facebook,
            'salon_capacity' => $this->max_members,
            'salon_members' => $this->countUsers(),
            'user_info' => UserPaymentResource::collection($users)
        ];
    }
}
