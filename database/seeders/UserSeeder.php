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
            'phone_number' => '0551111111',
            'address' => 'Admin Address',
            'gender' => 'male'
        ]);
        $admin->assignRole('admin');
        Employee::create([
            'user_id' => $admin->id,
            'department_id' => Department::where('name', 'Administration')->first()->id,
            'joining_date' => '2024-01-01',
            'salary' => 10000,
            'bio' => 'Experienced administrator with a focus on healthcare management.',
        ]);

        // Create Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin User',
            'email' => 'superadmin@medicareplus.com',
            'password' => Hash::make('password'),
            'phone_number' => '0551111112',
            'address' => 'Admin Address',
            'gender' => 'male'
        ]);
        $superAdmin->assignRole(['super-admin', 'admin', 'doctor']);
        Employee::create([
            'user_id' => $superAdmin->id,
            'department_id' => Department::where('name', 'Administration')->first()->id,
            'joining_date' => '2024-01-01',
            'salary' => 10000,
            'bio' => 'Senior administrator with extensive healthcare system experience.',
        ]);

        // Create Doctor
        $doctor = User::create([
            'name' => 'Dr. John Smith',
            'email' => 'doctor@medicareplus.com',
            'password' => Hash::make('password'),
            'phone_number' => '0552222222',
            'address' => 'Doctor Address',
            'gender' => 'male'
        ]);
        $doctor->assignRole('doctor');
        Employee::create([
            'user_id' => $doctor->id,
            'department_id' => Department::where('name', 'Medical')->first()->id,
            'joining_date' => '2024-01-01',
            'salary' => 15000,
            'bio' => 'Experienced physician specializing in general medicine.',
        ]);

        // Create Nurse
        $nurse = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'nurse@medicareplus.com',
            'password' => Hash::make('password'),
            'phone_number' => '0553333333',
            'address' => 'Nurse Address',
            'gender' => 'female'
        ]);
        $nurse->assignRole('nurse');
        Employee::create([
            'user_id' => $nurse->id,
            'department_id' => Department::where('name', 'Nursing')->first()->id,
            'joining_date' => '2024-01-01',
            'salary' => 8000,
            'bio' => 'Dedicated nurse with expertise in patient care.',
        ]);

        // Create Receptionist
        $receptionist = User::create([
            'name' => 'Emma Davis',
            'email' => 'receptionist@medicareplus.com',
            'password' => Hash::make('password'),
            'phone_number' => '0554444444',
            'address' => 'Receptionist Address',
            'gender' => 'female'
        ]);
        $receptionist->assignRole('receptionist');
        Employee::create([
            'user_id' => $receptionist->id,
            'department_id' => Department::where('name', 'Front Desk')->first()->id,
            'joining_date' => '2024-01-01',
            'salary' => 6000,
            'bio' => 'Professional receptionist with excellent customer service skills.',
        ]);

        // Create Pharmacist
        $pharmacist = User::create([
            'name' => 'Michael Brown',
            'email' => 'pharmacist@medicareplus.com',
            'password' => Hash::make('password'),
            'phone_number' => '0555555555',
            'address' => 'Pharmacist Address',
            'gender' => 'male'
        ]);
        $pharmacist->assignRole('pharmacist');
        Employee::create([
            'user_id' => $pharmacist->id,
            'department_id' => Department::where('name', 'Pharmacy')->first()->id,
            'joining_date' => '2024-01-01',
            'salary' => 9000,
            'bio' => 'Licensed pharmacist with extensive knowledge of medications.',
        ]);

        // Create Lab Technician
        $labTech = User::create([
            'name' => 'David Wilson',
            'email' => 'labtech@medicareplus.com',
            'password' => Hash::make('password'),
            'phone_number' => '0556666666',
            'address' => 'Lab Technician Address',
            'gender' => 'male'
        ]);
        $labTech->assignRole('lab_technician');
        Employee::create([
            'user_id' => $labTech->id,
            'department_id' => Department::where('name', 'Laboratory')->first()->id,
            'joining_date' => '2024-01-01',
            'salary' => 7000,
            'bio' => 'Skilled laboratory technician with expertise in medical testing.',
        ]);

        // Create Accountant
        $accountant = User::create([
            'name' => 'Lisa Anderson',
            'email' => 'accountant@medicareplus.com',
            'password' => Hash::make('password'),
            'phone_number' => '0557777777',
            'address' => 'Accountant Address',
            'gender' => 'female'
        ]);
        $accountant->assignRole('accountant');
        Employee::create([
            'user_id' => $accountant->id,
            'department_id' => Department::where('name', 'Finance')->first()->id,
            'joining_date' => '2024-01-01',
            'salary' => 8000,
            'bio' => 'Certified accountant with healthcare finance experience.',
        ]);

        // Create Patient (Isaac Nabil)
        $patient = User::create([
            'name' => 'Isaac Nabil',
            'email' => 'nabilkhafali@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '0557777777',
            'address' => 'Patient Address',
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
                'phone_number' => '0557777777',
                'address' => 'Patient Address',
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
