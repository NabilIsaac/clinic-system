<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'checkup_id',
        'bill_number',
        'bill_date',
        'total_amount',
        'paid_amount',
        'status',
        'due_date',
        'notes'
    ];

    protected $casts = [
        'bill_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id')
        ->whereHas('patient')
        ->with('patient');
    }

    public function getPatientDetailsAttribute()
    {
        return $this->patient;
    }

    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }

    public function items()
    {
        return $this->hasMany(BillItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getRemainingAmountAttribute()
    {
        return $this->total_amount - $this->paid_amount;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
