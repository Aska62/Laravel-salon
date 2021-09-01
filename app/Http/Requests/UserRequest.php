<?php

namespace App\Http\Requests;

use App\Models\Salon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users', 'email')->where(function($query) use($request) {
                    $query->where('salon_id', $request->salon_id)
                        ->whereNull('deleted_at');
                }),
                Rule::unique('owners', 'email')->where(function($query) use($request) {
                    $query->where('id', [Salon::select('owner_id')
                        ->where('id', $request->salon_id)
                        ->whereNull('deleted_at')
                        ->first()['owner_id']]
                    );
                })
            ]
        ];
    }
    /**
     * Determine attibutes.
     *
     * @return array
     */
    public function attributes() {
        return [
            'name' => '名前',
            'email' => 'メールアドレス'
        ];
    }
    /**
     * Error messages
     *
     * @return array
     */
    public function messages() {
        return [
            'email:unique' => 'このメールアドレスは登録済みです。'
        ];
    }
}
