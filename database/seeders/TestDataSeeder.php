<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if they don't exist
        $roles = ['super-admin', 'admin', 'doctor', 'nurse', 'patient', 'staff'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Create departments
        $departments = [
            'Cardiology',
            'Neurology',
            'Pediatrics',
            'Orthopedics',
            'Dermatology'
        ];

        foreach ($departments as $deptName) {
            Department::firstOrCreate(
                ['name' => $deptName],
                ['is_active' => true]
            );
        }

        // Create doctors for each department
        $departments = Department::all();
        foreach ($departments as $dept) {
            for ($i = 1; $i <= 3; $i++) {
                $doctor = User::firstOrCreate(
                    ['email' => "doctor{$dept->id}_{$i}@example.com"],
                    [
                        'name' => "Dr. Smith {$dept->id}_{$i}",
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                        'department_id' => $dept->id
                    ]
                );
                $doctor->assignRole('doctor');
            }
        }

        // Create patients
        for ($i = 1; $i <= 20; $i++) {
            $patient = User::firstOrCreate(
                ['email' => "patient{$i}@example.com"],
                [
                    'name' => "Patient {$i}",
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()
                ]
            );
            $patient->assignRole('patient');
        }

        // Create appointments
        $statuses = ['pending', 'completed', 'cancelled'];
        $patients = User::role('patient')->get();
        $doctors = User::role('doctor')->get();

        foreach ($patients as $patient) {
            $appointmentCount = rand(1, 3);
            for ($i = 0; $i < $appointmentCount; $i++) {
                $doctor = $doctors->random();
                $status = $statuses[array_rand($statuses)];
                $date = Carbon::now()->subDays(rand(0, 30))->addHours(rand(9, 17));

                Appointment::firstOrCreate(
                    [
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'appointment_datetime' => $date
                    ],
                    [
                        'department_id' => $doctor->department_id,
                        'status' => $status,
                        'notes' => "Test appointment notes"
                    ]
                );
            }
        }
    }
}
