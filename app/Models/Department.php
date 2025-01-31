<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function doctors()
    {
        return $this->hasMany(User::class)->role('doctor');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
