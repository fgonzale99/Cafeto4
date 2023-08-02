<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectosEval extends Model
{

    protected $connection = 'acaccomc_eval';
    protected $table = 'proyectos';

    public function getInvestigador()
    {
        return $this->belongsTo('App\Models\Investigador','codigo_investigador','codigo_investigador');
    }

}
