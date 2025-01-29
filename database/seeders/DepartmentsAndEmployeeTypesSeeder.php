<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\EmployeeType;

class DepartmentsAndEmployeeTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Departments
        $departments = [
            'Administration',
            'Medical',
            'Nursing',
            'Front Desk',
            'Pharmacy',
            'Laboratory',
            'Finance',
        ];

        foreach ($departments as $department) {
            Department::create(['name' => $department]);
        }

        // Create Employee Types
        $employeeTypes = [
            'Administrator',
            'Doctor',
            'Nurse',
            'Receptionist',
            'Pharmacist',
            'Lab Technician',
            'Accountant',
        ];

        foreach ($employeeTypes as $type) {
            EmployeeType::create(['name' => $type]);
        }
    }
}
