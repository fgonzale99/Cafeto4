<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Investigador extends Model
{
    use Searchable;

    protected $connection = 'acaccomc_eval';
    protected $table = 'investigadores';

    protected $fillable = ['par'];

    public function getArticulos(){
      return $this->hasMany('App\Models\Articulo', 'codigo_investigador', 'codigo_investigador');
    }

    public function getProyectos(){
      return $this->hasMany('App\Models\ProyectosEval', 'codigo_investigador', 'codigo_investigador');
    }

    public function getLibros(){
      return $this->hasMany('App\Models\Libro', 'codigo_investigador', 'codigo_investigador');
    }

}
