<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    public function user(){
    	return $this->belongsTo('App\User', 'userId');
    }
}
