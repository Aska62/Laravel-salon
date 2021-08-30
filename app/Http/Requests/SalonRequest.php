<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //[ *1.変更：default=false ]
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'owner_name' => 'required',
            'email' => 'required',
            'profile' => 'required',
            'name' => [
                'required',
                Rule::unique('salons', 'name')->whereNull('deleted_at')
            ],
            'fee' => 'required|numeric|min:100',
            'abstract' => 'required',
            'recommend' => 'required',
            'benefit' => 'required',
            'facebook' => 'required',
            'max_members' => 'required|numeric|min:1',
            'image' => 'required|max:1024|mimes:jpeg,jpg,png'
        ];
    }
    /**
     * Determine attibutes.
     *
     * @return array
     */
    public function attributes() {
        return [
            'owner_name' => 'オーナー様のお名前',
            'email' => 'メールアドレス',
            'profile' => 'オーナープロフィール',
            'name' => 'サロン名',
            'fee' => '月会費',
            'abstract' => 'サロン概要',
            'recommend' => 'こんな方におすすめ',
            'benefit' => '特典',
            'facebook' => 'facebook URL',
            'max_members' => '最大会員数',
            'image' => '画像'
        ];
    }
    /**
     * Error messages
     */
    public function messages() {
        return [
            'name.unique'  => '※同名のサロンが登録されています。',
            'fee.numeric' => '※半角数字で入力してください。',
            'fee.min'  => '※月会費は100円以上に設定してください。',
            'max_members.numeric' => '※半角数字で入力してください。',
            'max_members.min' => '※最大会員数は1名以上に設定してください。',
            'image.max'  => '※画像は1M以内のファイルをアップロードしてください。',
            'image.mimes:jpeg,jpg,png'  => '※jpeg、jpg、png形式の画像ファイルを選んでください。'
        ];
    }
}
