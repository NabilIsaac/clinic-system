<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payslip extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'payslip_number',
        'pay_date',
        'basic_salary',
        'allowances',
        'deductions',
        'net_salary',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'pay_date' => 'date',
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payslip) {
            $payslip->net_salary = $payslip->basic_salary + $payslip->allowances - $payslip->deductions;
        });

        static::updating(function ($payslip) {
            $payslip->net_salary = $payslip->basic_salary + $payslip->allowances - $payslip->deductions;
        });
    }
}
