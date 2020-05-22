<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    //

    use Notifiable;

    protected $guard = 'staff';

    protected $fillable = [
        'first_name', 'surname', 'email', 'department', 'password', 'university'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function staff_message()
    {
        return $this->hasMany('App\Staff_message');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

}
