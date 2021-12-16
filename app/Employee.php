<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function Attendances() {
        $this->hasMany('App\Attendance');
    }
}
