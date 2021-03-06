<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Admin extends Model
{
    public $timestamps = false;

    protected static function boot() {
        parent::boot();

        static::addGlobalScope('delete_flg', function (Builder $builder) {
            $builder->where('delete_flg', 0);
        });
    }
}
