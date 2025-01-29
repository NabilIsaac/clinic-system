<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Drug extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'generic_name',
        'description',
        'price',
        'stock_quantity',
        'unit',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function prescriptionDrugs()
    {
        return $this->hasMany(PrescriptionDrug::class);
    }
}
