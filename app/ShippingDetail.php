<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    protected $table = 'shipping_details';
    protected $primaryKey = 'shipping_details_id';
    public $timestamps = false;

    protected $fillable = [
      'active'  
    ];
}
