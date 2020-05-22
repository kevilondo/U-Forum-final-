<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff_comment extends Model
{
    //Table name
    protected $table = 'staff_comments';

    //Primary key
    protected $primaryKey = 'id';
    
    //Timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    public function message()
    {
        return $this->belongsTo('App\Staff_message');
    }

}
