<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status', // pending, processing, shipped, delivered, cancelled
        'shipping_address',
        'payment_status',
        'tracking_number',
        'reference',
        'payment_reference'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProducts()
    {
        return $this->items()->where('product_type', 'App\Models\Product')->get();
    }

    public function getDrugs()
    {
        return $this->items()->where('product_type', 'App\Models\Drug')->get();
    }
}
