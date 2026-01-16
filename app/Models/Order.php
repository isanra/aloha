<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Ini biar kita bisa langsung create data pakai array
    protected $guarded = []; 

    // INI YANG KURANG TADI:
    // Memberi tahu Laravel kalau 1 Order punya banyak Items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}