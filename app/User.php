<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'student_id', 'email', 'password', 'course', 'university', 'secret_question', 'answer', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'users';
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot() 
    {
        parent::boot();

        static::deleting(function($user) { 
            $user->comment()->delete();
            $user->notif()->delete();
            $user->bookstore()->delete();
            $user->topic()->delete();
            $user->articles()->delete();
        });
    }

    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    public function topic()
    {
        return $this->hasMany('App\Topic');
    }

    public function bookstore()
    {
        return $this->hasMany('App\Bookstore');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function notif()
    {
        return $this->hasMany('App\Notif');
    }

    public function video()
    {
        return $this->hasMany('App\Video');
    }
}
