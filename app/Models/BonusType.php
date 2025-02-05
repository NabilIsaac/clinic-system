<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusType extends Model
{
    protected $fillable = [
        'name', 'code', 'description', 'is_percentage',
        'default_value', 'role_multipliers', 'requires_approval', 'is_active'
    ];

    protected $casts = [
        'is_percentage' => 'boolean',
        'requires_approval' => 'boolean',
        'is_active' => 'boolean',
        'role_multipliers' => 'array'
    ];

    public function calculateBonus(Employee $employee, $baseAmount = null)
    {
        $baseAmount = $baseAmount ?? $this->default_value;
        $roleMultiplier = $this->role_multipliers[$employee->role] ?? 1;
        
        if ($this->is_percentage) {
            return ($employee->basic_salary * ($baseAmount / 100)) * $roleMultiplier;
        }
        
        return $baseAmount * $roleMultiplier;
    }
}
