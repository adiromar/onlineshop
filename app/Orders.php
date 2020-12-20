<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'ordersBackup';

    public function product(){
    	return $this->belongsTo('App\Product');
    }
}
