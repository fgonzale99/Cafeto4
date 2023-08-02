<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class Reviewer extends User
{

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\ReviewerScope);

        self::created(function($user) {

          DB::table('model_has_roles')->insert([
              'model_id' => $user->id,
              'model_type' => 'App\Models\User',
              'role_id' => 4,
          ]);
        });
    }
}
