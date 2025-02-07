<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_type',
        'quantity',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
