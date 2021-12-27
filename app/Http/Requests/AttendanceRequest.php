<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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
            'year' => 'required',
            'month' => 'required|between:1,12',
            'start_time_h' => 'required|between:1,23',
            'start_time_m' => 'required|between:0,59',
            'end_time_h' => 'required|between:1,23',
            'end_time_m' => 'required|between:0,59',
            'break_time' => 'required',
        ];
        
        $leapyear = Carbon::createFromDate($this->year, $this->month, $this->day);

        if ($this->month == '2' && date('L', $leapyear)) {
            return [
                'day' => 'required|between:1,29',
            ];
        } elseif ($this->month == '2' && !(date('L', $leapyear))) {
            return [
                'day' => 'required|between:1,28',
            ];
        } elseif ($this->month == '4' || $this->month == '6' || $this->month == '9' || $this->month == '11') {
            return [
                'day' => 'required|between:1,30',
            ];
        } else {
            return [
                'day' => 'required|between:1,31',
            ];
        }
    }

    public function messages() {
        return [
            'year.required' => '勤務日で入力されていない部分があります。',
            'month.required' => '勤務日で入力されていない部分があります。',
            'month.between' => '無効な日付です。',
            'day.required' => '勤務日で入力されていない部分があります。',
            'day.between' => '無効な日付です。',
            'start_time_h.required' => '始業時間は必須項目です。',
            'start_time._h.between' => '0時0分～23時59分の間で入力してください。',
            'start_time_m.required' => '始業時間は必須項目です。',
            'start_time._m.between' => '0時0分～23時59分の間で入力してください。',
            'end_time_h.required' => '終業時間は必須項目です。',
            'end_time._h.between' => '0時0分～23時59分の間で入力してください。',
            'end_time_m.required' => '終業時間は必須項目です。',
            'end_time._m.between' => '0時0分～23時59分の間で入力してください。',
            'break_time.required' => '休憩時間は必須項目です。',
        ];
    }
}
