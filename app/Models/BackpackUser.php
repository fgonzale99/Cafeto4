<?php

namespace App\Models;

use App\Models\User;
use Backpack\CRUD\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait; // <------------------------------- this one
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one
use Illuminate\Foundation\Auth\User as Authenticatable;


class BackpackUser extends User
{
    use Notifiable;

    use CrudTrait; // <----- this
    use HasRoles; // <------ and this

    protected $table = 'users';

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }
}
