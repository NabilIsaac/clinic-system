<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Checkup extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'bp',
        'total_amount',
        'reason',
        'visit_history',
        'notes',
        'status'
    ];
    
    protected $casts = [
        'date' => 'datetime',
        'symptoms' => 'array',
        'total_amount' => 'decimal:2'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function medications()
    {
        return $this->hasMany(CheckupMedication::class);
    }
    
    public function products()
    {
        return $this->hasMany(CheckupProduct::class);
    }

    public static function getStatuses()
    {
        return [
            'in-progress',
            'completed',
            'cancelled'
        ];
    }

    public function procedures()
    {
        return $this->hasMany(CheckupProcedure::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->whereHas('patient', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })->orWhereHas('doctor', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('status', $status);
        });

        $query->when($filters['date_from'] ?? false, function ($query, $date) {
            $query->whereDate('created_at', '>=', $date);
        });

        $query->when($filters['date_to'] ?? false, function ($query, $date) {
            $query->whereDate('created_at', '<=', $date);
        });
    }
}
