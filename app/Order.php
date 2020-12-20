<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function orderDetail()
    {
    	return $this->hasMany('App\OrderDetail', 'order_id');
    }

    protected $fillable = [
        'order_status'
    ];
}
