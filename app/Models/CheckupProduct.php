<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckupProduct extends Model
{
    protected $fillable = [
        'checkup_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price'
    ];

    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
