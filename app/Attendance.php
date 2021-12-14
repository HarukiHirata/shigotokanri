<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = array('id');

    // バリデーションルール
    public static $rules = array(
        'date' =>'required',
        'start_time' => 'required',
        'end_time' => 'required',
    );

    // 従業員テーブルとのリレーション
    public function employee() {
        $this->belongsTo('App\Employee');
    }
}
