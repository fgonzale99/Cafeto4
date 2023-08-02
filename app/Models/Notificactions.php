<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = 'notificacions';

    public function roles() {
        return $this->belongsToMany(\App\RolesModel::class, 'notificacion_role','notificacion_id','role_id');
    }

    public function proyectos() {
        return $this->belongsToMany(\App\proyectosModel::class, 'notificacion_proyecto','notificacion_id','proyecto_id');
    }

    public function usuarios() {
        return $this->belongsToMany(\App\User::class, 'notificacion_user','notificacion_id','user_id');
    }

}
