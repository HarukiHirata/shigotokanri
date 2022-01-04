<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required',
            'company_code' => 'required|unique:companies,company_code',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '会社名は必須項目です。',
            'company_code.required' => '企業コードは必須項目です。',
            'company_code.unique' => '入力された企業コードは既に使用されています。',
            'email.required' => 'メールアドレスは必須項目です。',
            'email.email' => '正しいメールアドレスの形式で入力してください。',
            'password.required' => 'パスワードは必須項目です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
        ];
    }
}
