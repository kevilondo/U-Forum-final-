<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat_list extends Model
{
    //Table name
    protected $table = 'chat_list';

    //Primary key
    protected $primaryKey = 'id';
    
    //Timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}