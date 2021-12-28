<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AttendanceRequest extends FormRequest
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
            'year' => 'required|numeric',
            'month' => 'required|numeric',
            'day' => 'required|numeric',
            'start_time_h' => 'required|numeric|between:0,23',
            'start_time_m' => 'required|numeric|between:0,59',
            'end_time_h' => 'required|numeric|between:0,23',
            'end_time_m' => 'required|numeric|between:0,59',
            'break_time' => 'required|numeric',
        ];
    }

    public function messages() {
        return [
            'year.required' => '年が入力されていません。',
            'year.numeric' => '年は数値で入力してください。',
            'month.required' => '月が入力されていません。',
            'month.numeric' => '月は数値で入力してください。',
            'day.required' => '日が入力されていません。',
            'day.numeric' => '日は数値で入力してください。',
            'start_time_h.required' => '始業時間（時）は必須項目です。',
            'start_time._h.between' => '0時～23時の間で入力してください。',
            'start_time_h.numeric' => '始業時間（時）は数値で入力してください。',
            'start_time_m.required' => '始業時間（分）は必須項目です。',
            'start_time._m.between' => '0分～59分の間で入力してください。',
            'start_time_m.numeric' => '始業時間（分）は数値で入力してください。',
            'end_time_h.required' => '終業時間（時）は必須項目です。',
            'end_time._h.between' => '0時～23時の間で入力してください。',
            'end_time_h.numeric' => '始業時間（時）は数値で入力してください。',
            'end_time_m.required' => '終業時間（分）は必須項目です。',
            'end_time._m.between' => '0分～59分の間で入力してください。',
            'end_time_m.numeric' => '終業時間（分）は数値で入力してください。',
            'break_time.required' => '休憩時間は必須項目です。',
            'break_time.numeric' => '休憩時間は数値で入力してください。',
        ];
    }
}
