<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;

    public static $rules = array(
        'company_code' => 'required',
        'name' => 'required',
        'email' => 'required',
        'password' => 'required|min:8',
    );
}
