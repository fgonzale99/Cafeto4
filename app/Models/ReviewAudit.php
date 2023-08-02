<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ReviewAudit extends User
{

  protected $table = 'reviewAudit';

  protected $fillable = ['review','user','newReviewer','reviewerRating','reviewerConcept','reviewRating','reviewConcept','reviewCompleted','reviewSettings','finalComments','state','daysLimit','assignDate'];

  public function getReview()
  {
      return $this->belongsTo('App\Models\ProjectReview','review','id');
  }

  public function getCommittee()
  {
      return $this->belongsTo('App\Models\Committee','user','id');
  }

  public function get_committee()
  {
      return $this->belongsTo('App\Models\Committee','user','id');
  }

  public function get_user()
  {
      return $this->belongsTo('App\Models\User','user','id');
  }
}
