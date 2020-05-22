<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffNotif extends Model
{
    //Table name
    protected $table = 'staff_notifs';

    //Primary key
    protected $primaryKey = 'id';
    
    //Timestamps
    public $timestamps = true;

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    public function message()
    {
        return $this->hasMany('App\Staff_message');
    }
}
