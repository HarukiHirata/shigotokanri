<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Attendance extends Model
{
    public $timestamps = false;
    
    protected static function boot() {
        parent::boot();

        static::addGlobalScope('delete_flg', function (Builder $builder) {
            $builder->where('delete_flg', 0)->orderBy('date', 'asc');
        });
    }
    
    protected $guarded = array('id');

    // 従業員テーブルとのリレーション
    public function employee() {
        return $this->belongsTo("App\Employee");
    }
}
