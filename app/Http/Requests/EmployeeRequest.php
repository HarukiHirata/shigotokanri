<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
            'employee_code' => [
                'required',
                Rule::unique('employees')->where('company_code', session('company_code'))->where('delete_flg', 0)->ignore($this->employee_id),
            ],
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }

    public function messages() {
        return [
            'employee_code.required' => '従業員コードは必須項目です。',
            'employee_code.unique' => '入力された従業員コードは企業内で既に使用されています。',
            'name.required' => '氏名は必須項目です。',
            'email.required' => 'メールアドレスは必須項目です。',
            'email.email' => '正しいメールアドレスの形式で入力してください。',
            'password.required' => 'パスワードは必須項目です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
        ];
    }
}
