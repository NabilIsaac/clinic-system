<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionDrug extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'drug_id',
        'quantity',
        'dosage',
        'frequency',
        'duration',
        'duration_unit',
        'instructions',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
}
