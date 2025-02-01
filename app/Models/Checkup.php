<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'symptoms',
        'diagnosis',
        'notes',
        'date',
        'status'
    ];
    
    protected $casts = [
        'date' => 'datetime',
        'symptoms' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function procedures()
    {
        return $this->hasMany(CheckupProcedure::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }
}
