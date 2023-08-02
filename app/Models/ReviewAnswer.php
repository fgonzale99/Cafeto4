<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewAnswer extends Model
{

    protected $table = 'reviewAnswer';

    protected $fillable = ['answer'];

    public function reviewer()
    {
       return $this->belongsTo('App\Models\Reviewer', 'reviewer');
    }

}
