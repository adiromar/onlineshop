<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetailNew extends Model
{
    protected $table = 'order_detail_new';

    public function OrderNew()
    {
    	return $this->belongsTo('App\OrderNew');
    }
}
