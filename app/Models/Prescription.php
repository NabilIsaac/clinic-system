<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'diagnosis_id',
        'patient_id',
        'doctor_id',
        'prescription_number',
        'issue_date',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'doctor_id');
    }

    public function prescriptionDrugs()
    {
        return $this->hasMany(PrescriptionDrug::class);
    }

    public function billItem()
    {
        return $this->morphOne(BillItem::class, 'billable');
    }
}
