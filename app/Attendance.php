<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Attendance extends Model
{
    protected static function boot() {
        parent::boot();

        static::addGlobalScope('delete_flg', function (Builder $builder) {
            $builder->where('delete_flg', 0);
        });
    }
    
    protected $guarded = array('id');

    // バリデーションルール
    public static $rules = array(
        'date' =>'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'break_time' => 'required',
    );

    // 従業員テーブルとのリレーション
    public function employee() {
        $this->belongsTo('App\Employee');
    }
}
