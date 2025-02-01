<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'billable_type',
        'billable_id',
        'description',
        'amount',
        'quantity',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function billable()
    {
        return $this->morphTo();
    }

    public function getTotalAttribute()
    {
        return $this->amount * $this->quantity;
    }
}
