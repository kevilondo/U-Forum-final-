<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff_message extends Model
{
    //Table name
    protected $table = 'staff_messages';

    //Primary key
    protected $primaryKey = 'id';
    
    //Timestamps
    public $timestamps = true;

    public static function boot() 
    {
        parent::boot();

        static::deleting(function($staff_message) { 
            $staff_message->comment()->delete();
            $staff_message->notif()->delete(); 
        });
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    public function staff_comments()
    {
        return $this->hasMany('App\Staff');
    }

    public function notif()
    {
        return $this->hasMany('App\Notif');
    }
}
