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

            // Pharmacy permissions
            'manage drugs',
            'dispense medication',

            // Lab permissions
            'manage lab tests',
            'record test results',
            'view test orders',

            // Accountant permissions
            'manage finances',
            'create bills',
            'process payments',
            'generate financial reports',

            // Receptionist permissions
            'schedule appointments',
            'register patients',
            'manage patient records',
            'process basic payments',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create super-admin role with all permissions
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Create roles and assign permissions
        // Admin Role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'manage users',
            'manage roles',
            'manage departments',
            'manage employees',
            'manage patients',
            'manage billing',
            'manage inventory',
            'view reports',
            'manage settings',
        ]);

        // Doctor Role
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

        // Nurse Role
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

        // Receptionist Role
        $receptionistRole = Role::create(['name' => 'receptionist']);
        $receptionistRole->givePermissionTo([
            'schedule appointments',
            'register patients',
            'manage patient records',
            'process basic payments',
            'view appointments',
            'view own schedule',
        ]);

        // Pharmacist Role
        $pharmacistRole = Role::create(['name' => 'pharmacist']);
        $pharmacistRole->givePermissionTo([
            'manage drugs',
            'dispense medication',
            'view prescriptions',
            'view own schedule',
        ]);

        // Lab Technician Role
        $labTechRole = Role::create(['name' => 'lab_technician']);
        $labTechRole->givePermissionTo([
            'manage lab tests',
            'record test results',
            'view test orders',
            'view own schedule',
        ]);

        // Accountant Role
        $accountantRole = Role::create(['name' => 'accountant']);
        $accountantRole->givePermissionTo([
            'manage finances',
            'create bills',
            'process payments',
            'generate financial reports',
            'view own schedule',
        ]);

        // Patient Role
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
    }
}
