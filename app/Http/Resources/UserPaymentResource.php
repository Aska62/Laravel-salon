<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPaymentResource extends JsonResource
{
    public static $wrap = 'user_info';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->id,
            'user_name' => $this->name,
            'payment_history' => $this->getAllPaymentYM()
        ];
    }
}
