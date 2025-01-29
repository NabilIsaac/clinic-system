<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'test_type_id',
        'diagnosis_id',
        'test_number',
        'test_datetime',
        'results',
        'notes',
        'status',
    ];

    protected $casts = [
        'test_datetime' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'doctor_id');
    }

    public function testType()
    {
        return $this->belongsTo(TestType::class);
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function billItem()
    {
        return $this->morphOne(BillItem::class, 'billable');
    }
}
