<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewUnit extends Model
{

    protected $table = 'review_unit';

    public function reviewer()
    {
       return $this->belongsTo('App\Models\Reviewer', 'idEvaluador');
    }

}
