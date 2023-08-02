<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewFee extends Model
{

    protected $table = 'reviewFee';

    protected $fillable = ['price','description','startDate','dueDate'];


}
