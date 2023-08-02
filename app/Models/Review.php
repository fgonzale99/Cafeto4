<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $table = 'review';

    public function files()
    {
        return $this->hasMany('App\Models\File','elementId','id');
    }
}
