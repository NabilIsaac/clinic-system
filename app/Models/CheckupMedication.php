<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckupMedication extends Model
{
    protected $fillable = [
        'checkup_id',
        'drug_id',
        'quantity',
        'dosage',
        'unit_price',
        'total_price'
    ];

    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    } 
}
