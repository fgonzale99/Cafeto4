<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectReviewLog extends Model
{

    protected $table = 'projectReviewLog';

    protected $fillable = ['projectReview', 'event', 'description', 'date', 'state'];

    public function getReviewer()
    {
        return $this->belongsTo('App\Models\Reviewer','reviewer','id');
    }
}
