<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // 権限を持っているかを確認 → trueなら持っている
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $myEmail = Auth::user()->email;

        return [
            // バリデーションルールを記述
            'name' => 'required|string|max:255',
            'email' => ['required', 
                        'string', 
                        'email', 
                        'max:255', 
                        Rule::unique('users', 'email')->whereNot('email', $myEmail)],
        ];
    }
}
