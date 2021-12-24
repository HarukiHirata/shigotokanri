<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Admin;

class AdminRequest extends FormRequest
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
        $companyCode = session('company_code');
        return [
            'admin_code' => [
                'required',
                Rule::unique('admins')->where('company_code', session('company_code'))->where('delete_flg', 0)->ignore($this->admin_id),
            ],
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required|min:8',
        ];
    }

    public function messages() {
        return [
            'admin_code.required' => '管理者コードは必須項目です。',
            'admin_code.unique' => '入力された管理者コードは企業内で既に使用されています。',
            'email.required' => 'メールアドレスは必須項目です。',
            'email.email' => '正しいメールアドレスの形式で入力してください。',
            'role.required' => '権限は必須項目です。',
            'password.required' => 'パスワードは必須項目です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
        ];
    }
}
