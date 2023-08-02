<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationMessage extends Model
{

    protected $table = 'notificationMessage';

    protected $fillable = ['name', 'message', 'model', 'elementId', 'event', 'module', 'date', 'state', 'user'];


}
