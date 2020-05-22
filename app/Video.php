<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //Table name
    protected $table = 'videos';

    //Primary key
    protected $primaryKey = 'id';
         
    //Timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
