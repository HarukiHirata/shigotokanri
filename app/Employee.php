<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Employee extends Model
{
    public $timestamps = false;
    
    protected static function boot() {
        parent::boot();

        static::addGlobalScope('delete_flg', function (Builder $builder) {
            $builder->where('delete_flg', 0);
        });
    }

    public function attendances() {
        return $this->hasMany("App\Attendance");
    }

    public static $rules = array(
        'employee_code' => 'required',
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8',
    );
}
