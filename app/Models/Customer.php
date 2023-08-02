<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = ['name','document','documentType','description','contactName','contactEmail','contactPhone','city','state'];

    protected $table = 'customer';

}
