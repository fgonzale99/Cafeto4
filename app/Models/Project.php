<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $table = 'projects';

    protected $fillable = ['name', 'process', 'program', 'code', 'date', 'feeType', 'feeCustom', 'formReview','formatReview', 'state'];

    public function getProcess()
    {
        return $this->belongsTo('App\Models\Process','process','id');
    }

    public function getProjecReviews()
    {
      return $this->hasMany('App\Models\ProjectReview','project','id');
    }

    public function getFormreview()
    {
        return $this->belongsTo('App\Models\FormReview','formReview','id');
    }

    public function files()
    {
        return $this->hasMany('App\Models\File','elementId','id');
    }

}
