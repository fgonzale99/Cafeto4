<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormatReview extends Model
{

    protected $table = 'formatReview';

    protected $fillable = ['name','content','header','footer','parameters','state'];

}
