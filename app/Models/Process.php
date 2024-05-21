<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{

    protected $table = 'process';

    protected $fillable = ['name','description','dateStart','dateFinish','responsible','customer','fileProcess','ethicCode','feeReview','project_unisono_id','budget_reviewer_id','paymentState','state','topBudgetDate','topBudget'];

    public function getCustomer()
    {
        return $this->belongsTo('App\Models\Customer','customer','id');
    }

    public function getResponsible()
    {
        return $this->belongsTo('App\Models\user','responsible','id');
    }

    public function getProjects()
    {
      return $this->hasMany('App\Models\Project','process','id');
    }

    public function getFeeReview()
    {
      return $this->belongsTo('App\Models\ReviewFee','feeReview','id');
    }

    public function files()
    {
        return $this->hasMany('App\Models\File','elementId','id');
    }

}
