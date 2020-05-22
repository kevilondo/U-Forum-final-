<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    //Table name
    protected $table = 'universities';

    //Primary key
    protected $primaryKey = 'id';
     
    //Timestamps
    public $timestamps = true;
 
}
