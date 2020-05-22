<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
     //Table name
     protected $table = 'articles';

     //Primary key
     protected $primaryKey = 'id';
     
     //Timestamps
     public $timestamps = true;

     public function user()
     {
          return $this->belongsTo('App\User');
     }
}
