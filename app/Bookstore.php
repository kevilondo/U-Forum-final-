<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookstore extends Model
{
    //Table name
    protected $table = 'books';

    //Primary key
    protected $primaryKey = 'id';
    
    //Timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
