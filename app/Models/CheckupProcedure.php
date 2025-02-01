<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckupProcedure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'checkup_id',
        'name',
        'description',
        'cost',
        'notes'
    ];

    protected $casts = [
        'cost' => 'decimal:2'
    ];

    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }
}
