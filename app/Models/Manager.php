<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Spatie\Permission\Models\Role;

class Manager extends User
{

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\ManagerScope);
    }

}
