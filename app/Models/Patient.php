<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'blood_type',
        'allergies',
        'chronic_diseases',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
