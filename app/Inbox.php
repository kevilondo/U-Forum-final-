<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    //Table name
    protected $table = 'inbox';

    //Primary key
    protected $primaryKey = 'id';
    
    //Timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
