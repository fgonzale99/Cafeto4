<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectReview extends Model
{

    protected $table = 'projectReview';

    protected $fillable = ['project', 'process', 'reviewer', 'par', 'daysLimit', 'assignDate', 'reviewDate', 'answer', 'result', 'progress', 'conflict', 'ethicCodeAccepted', 'termsAccepted', 'codeSignature', 'state', 'paymentId', 'feeCustom', 'paymentState'];

    public function getProject()
    {
        return $this->belongsTo('App\Models\Project','project','id');
    }

    public function getProcess()
    {
        return $this->belongsTo('App\Models\Process','process','id');
    }

    public function getReviewer()
    {
        return $this->belongsTo('App\Models\Reviewer','reviewer','id');
    }

    public function getFiles()
    {
        return $this->hasMany('App\Models\File','elementId','id');
    }

    public function audit()
    {
        return $this->hasMany('App\Models\ReviewAudit','review','id');
    }

    /*protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\ProjectReviewScope);
    }*/
}
