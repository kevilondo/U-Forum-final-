<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //Table name
    protected $table = 'topics';

    //Primary key
    protected $primaryKey = 'id';
    
    //Timestamps
    public $timestamps = true;

    public static function boot() 
    {
        parent::boot();

        static::deleting(function($topic) { 
            $topic->comment()->delete();
            $topic->notif()->delete(); 
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function notif()
    {
        return $this->hasMany('App\Notif');
    }

}
