<?php

namespace App\Observers;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeObserver
{
    /**
     * Handle the Employee "creating" event.
     */
    public function creating(Employee $employee): void
    {
        if (!$employee->employee_id) {
            $employee->employee_id = $this->generateEmployeeId();
        }
    }

    /**
     * Generate a unique employee ID.
     * Format: EMP-YYYY-XXXX where XXXX is a sequential number
     */
    protected function generateEmployeeId(): string
    {
        $year = date('Y');
        $lastEmployee = DB::table('employees')
            ->where('employee_id', 'like', "EMP-{$year}-%")
            ->orderBy('employee_id', 'desc')
            ->first();

        if ($lastEmployee) {
            $lastNumber = (int) substr($lastEmployee->employee_id, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "EMP-{$year}-{$newNumber}";
    }
}
