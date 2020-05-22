<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Notif extends Model
{
     //Table name
     protected $table = 'notifications';

     //Primary key
     protected $primaryKey = 'id';
     
     //Timestamps
     public $timestamps = true;
 
    public function user()
    {
        return $this->belongsTo('App\User');
    }
 
    public function forum()
    {
        return $this->belongsTo('App\Topic');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    public function staff_message()
    {
        return $this->belongsTo('App\Staff_message');
    }
}
