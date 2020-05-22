<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //Table name
    protected $table = 'courses';

    //Primary key
    protected $primaryKey = 'id';
    
    //Timestamps
    public $timestamps = true;
}
