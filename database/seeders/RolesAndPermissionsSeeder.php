<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Patient permissions
            'view own patient profile',
            'edit own patient profile',
            'view own appointments',
            'create own appointments',
            'view own prescriptions',
            'view own tests',
            'view own bills',
            'pay own bills',

            // Doctor permissions
            'view patients',
            'view patient profile',
            'edit patient medical info',
            'view appointments',
            'manage appointments',
            'create diagnosis',
            'edit diagnosis',
            'create prescription',
            'edit prescription',
            'order tests',
            'view test results',
            'view own schedule',
            'view prescriptions',

            // Nurse permissions
            'update patient vitals',
            'administer medication',

            // Admin permissions
            'manage users',
            'manage roles',
            'manage departments',
            'manage employees',
            'manage patients',
            'manage billing',
            'manage inventory',
            'view reports',
            'manage settings',

            // Staff permissions
            'create bills',
            'process payments',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $patientRole = Role::create(['name' => 'patient']);
        $patientRole->givePermissionTo([
            'view own patient profile',
            'edit own patient profile',
            'view own appointments',
            'create own appointments',
            'view own prescriptions',
            'view own tests',
            'view own bills',
            'pay own bills',
        ]);

        $doctorRole = Role::create(['name' => 'doctor']);
        $doctorRole->givePermissionTo([
            'view patients',
            'view patient profile',
            'edit patient medical info',
            'view appointments',
            'manage appointments',
            'create diagnosis',
            'edit diagnosis',
            'create prescription',
            'edit prescription',
            'order tests',
            'view test results',
            'view own schedule',
            'view prescriptions',
        ]);

        $nurseRole = Role::create(['name' => 'nurse']);
        $nurseRole->givePermissionTo([
            'view patients',
            'view patient profile',
            'update patient vitals',
            'view appointments',
            'view prescriptions',
            'administer medication',
            'view test results',
            'view own schedule',
        ]);

        $staffRole = Role::create(['name' => 'staff']);
        $staffRole->givePermissionTo([
            'view appointments',
            'manage appointments',
            'create bills',
            'process payments',
            'view own schedule',
        ]);

        // Super admin role - gets all permissions
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());
    }
}
