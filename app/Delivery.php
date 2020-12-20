<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'delivery_users';
    public $timestamps = false;

    public function user() {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
