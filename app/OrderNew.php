<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderNew extends Model
{
    protected $table = 'order_new';

    public function OrderDetailNew()
    {
    	return $this->hasMany('App\OrderDetailNew', 'orderId');
    }
}
