<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];

    // Kebalikannya: 1 Item milik 1 Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}