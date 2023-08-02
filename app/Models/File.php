<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $table = 'file';

    protected $fillable = ['name','file','description','model','field','elementId','user','state'];


}
