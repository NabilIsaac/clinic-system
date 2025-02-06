<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'email',
        'phone_number',
        'address',
        'date_of_birth',
        'gender',
        'marital_status',
        'occupation',
        'password',
        'department_id',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    /**
     * Get the employee record associated with the user.
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function doctorCheckups()
    {
        return $this->hasMany(Checkup::class, 'doctor_id');
    }

    public function patientCheckups()
    {
        return $this->hasMany(Checkup::class, 'patient_id');
    }
    
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'patient_id');
    }
}
