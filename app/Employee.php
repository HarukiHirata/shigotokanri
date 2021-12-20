<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
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
