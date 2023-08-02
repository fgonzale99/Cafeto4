<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormReview extends Model
{

    protected $table = 'formReview';

    protected $fillable = ['name','description','instructions','rules','form','state'];

}
