<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@medicareplus.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');
        Employee::create([
            'user_id' => $admin->id,
            'employee_type_id' => EmployeeType::where('name', 'Administrator')->first()->id,
            'department_id' => Department::where('name', 'Administration')->first()->id,
            'phone' => '0551111111',
            'address' => 'Admin Address',
            'joining_date' => '2024-01-01',
            'salary' => 10000,
            'bio' => 'Experienced administrator with a focus on healthcare management.',
            'gender' => 'male'
        ]);

        // Create Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin User',
            'email' => 'superadmin@medicareplus.com',
            'password' => Hash::make('password'),
        ]);
        $superAdmin->assignRole(['super-admin', 'admin', 'doctor']);
        Employee::create([
            'user_id' => $superAdmin->id,
            'employee_type_id' => EmployeeType::where('name', 'Administrator')->first()->id,
            'department_id' => Department::where('name', 'Administration')->first()->id,
            'phone' => '0551111112',
            'address' => 'Admin Address',
            'joining_date' => '2024-01-01',
            'salary' => 10000,
            'bio' => 'Senior administrator with extensive healthcare system experience.',
            'gender' => 'male'
        ]);

        // Create Doctor
        $doctor = User::create([
            'name' => 'Dr. John Smith',
            'email' => 'doctor@medicareplus.com',
            'password' => Hash::make('password'),
        ]);
        $doctor->assignRole('doctor');
        Employee::create([
            'user_id' => $doctor->id,
            'employee_type_id' => EmployeeType::where('name', 'Doctor')->first()->id,
            'department_id' => Department::where('name', 'Medical')->first()->id,
            'phone' => '0552222222',
            'address' => 'Doctor Address',
            'joining_date' => '2024-01-01',
            'salary' => 15000,
            'bio' => 'Experienced physician specializing in general medicine.',
            'gender' => 'male'
        ]);

        // Create Nurse
        $nurse = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'nurse@medicareplus.com',
            'password' => Hash::make('password'),
        ]);
        $nurse->assignRole('nurse');
        Employee::create([
            'user_id' => $nurse->id,
            'employee_type_id' => EmployeeType::where('name', 'Nurse')->first()->id,
            'department_id' => Department::where('name', 'Nursing')->first()->id,
            'phone' => '0553333333',
            'address' => 'Nurse Address',
            'joining_date' => '2024-01-01',
            'salary' => 8000,
            'bio' => 'Dedicated nurse with expertise in patient care.',
            'gender' => 'female'
        ]);

        // Create Receptionist
        $receptionist = User::create([
            'name' => 'Emma Davis',
            'email' => 'receptionist@medicareplus.com',
            'password' => Hash::make('password'),
        ]);
        $receptionist->assignRole('receptionist');
        Employee::create([
            'user_id' => $receptionist->id,
            'employee_type_id' => EmployeeType::where('name', 'Receptionist')->first()->id,
            'department_id' => Department::where('name', 'Front Desk')->first()->id,
            'phone' => '0554444444',
            'address' => 'Receptionist Address',
            'joining_date' => '2024-01-01',
            'salary' => 6000,
            'bio' => 'Professional receptionist with excellent customer service skills.',
            'gender' => 'female'
        ]);

        // Create Pharmacist
        $pharmacist = User::create([
            'name' => 'Michael Brown',
            'email' => 'pharmacist@medicareplus.com',
            'password' => Hash::make('password'),
        ]);
        $pharmacist->assignRole('pharmacist');
        Employee::create([
            'user_id' => $pharmacist->id,
            'employee_type_id' => EmployeeType::where('name', 'Pharmacist')->first()->id,
            'department_id' => Department::where('name', 'Pharmacy')->first()->id,
            'phone' => '0555555555',
            'address' => 'Pharmacist Address',
            'joining_date' => '2024-01-01',
            'salary' => 9000,
            'bio' => 'Licensed pharmacist with extensive knowledge of medications.',
            'gender' => 'male'
        ]);

        // Create Lab Technician
        $labTech = User::create([
            'name' => 'David Wilson',
            'email' => 'labtech@medicareplus.com',
            'password' => Hash::make('password'),
        ]);
        $labTech->assignRole('lab_technician');
        Employee::create([
            'user_id' => $labTech->id,
            'employee_type_id' => EmployeeType::where('name', 'Lab Technician')->first()->id,
            'department_id' => Department::where('name', 'Laboratory')->first()->id,
            'phone' => '0556666666',
            'address' => 'Lab Technician Address',
            'joining_date' => '2024-01-01',
            'salary' => 7000,
            'bio' => 'Skilled laboratory technician with expertise in medical testing.',
            'gender' => 'male'
        ]);

        // Create Accountant
        $accountant = User::create([
            'name' => 'Lisa Anderson',
            'email' => 'accountant@medicareplus.com',
            'password' => Hash::make('password'),
        ]);
        $accountant->assignRole('accountant');
        Employee::create([
            'user_id' => $accountant->id,
            'employee_type_id' => EmployeeType::where('name', 'Accountant')->first()->id,
            'department_id' => Department::where('name', 'Finance')->first()->id,
            'phone' => '0557777777',
            'address' => 'Accountant Address',
            'joining_date' => '2024-01-01',
            'salary' => 8000,
            'bio' => 'Certified accountant with healthcare finance experience.',
            'gender' => 'female'
        ]);

        // Create Patient (Isaac Nabil)
        $patient = User::create([
            'name' => 'Isaac Nabil',
            'email' => 'nabilkhafali@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $patient->assignRole('patient');
        Patient::create([
            'user_id' => $patient->id,
            'blood_type' => 'O+',
            'emergency_contact_name' => 'Emergency Contact',
            'emergency_contact_phone' => '0551562947',
            'emergency_contact_relation' => 'Family',
            'medical_history' => 'No significant medical history'
        ]);

        // Create additional patients
        $patientData = [
            [
                'name' => 'Sarah Smith',
                'email' => 'sarah.smith@example.com',
                'blood_type' => 'A+',
                'emergency_contact_phone' => '0551234567'
            ],
            [
                'name' => 'Mohammed Ali',
                'email' => 'mohammed.ali@example.com',
                'blood_type' => 'B+',
                'emergency_contact_phone' => '0559876543'
            ],
            [
                'name' => 'Emily Johnson',
                'email' => 'emily.j@example.com',
                'blood_type' => 'AB+',
                'emergency_contact_phone' => '0553456789'
            ]
        ];

        foreach ($patientData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('patient');
            Patient::create([
                'user_id' => $user->id,
                'blood_type' => $data['blood_type'],
                'emergency_contact_name' => 'Emergency Contact',
                'emergency_contact_phone' => $data['emergency_contact_phone'],
                'emergency_contact_relation' => 'Family',
                'medical_history' => 'No significant medical history'
            ]);
        }
    }
}
