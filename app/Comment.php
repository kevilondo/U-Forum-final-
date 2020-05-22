<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //Table name
    protected $table = 'comments';

    //Primary key
    protected $primaryKey = 'id';
    
    //Timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }
}
