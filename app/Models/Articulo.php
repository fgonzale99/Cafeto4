<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{

    protected $connection = 'acaccomc_eval';
    protected $table = 'articulos';

    public function getInvestigador()
    {
        return $this->belongsTo('App\Models\Investigador','codigo_investigador','codigo_investigador');
    }

}
