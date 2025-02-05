<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        // 'notes'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
