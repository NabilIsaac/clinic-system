<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\EmployeeObserver;

#[ObservedBy([EmployeeObserver::class])]
class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'employee_type_id',
        'employee_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'date_of_birth',
        'hire_date',
        'salary',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'doctor_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'doctor_id');
    }

    public function leaves()
    {
        return $this->hasMany(EmployeeLeave::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function weeklySchedules()
    {
        return $this->hasMany(WeeklySchedule::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
