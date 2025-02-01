<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Admin\EmployeePortalController;
use App\Http\Controllers\ViewStateController;
use App\Http\Controllers\Admin\LeaveRequestController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\StaffScheduleController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Patient\PrescriptionController;
use App\Http\Controllers\Patient\BillController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\BillController as AdminBillController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Doctor\CheckupController;
use App\Http\Controllers\Patient\HealthAssessmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Auth::routes();

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/update-view', [ViewStateController::class, 'updateView'])->name('update-view');
});

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        if (auth()->user()->hasAnyRole(['admin', 'super-admin'])) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->hasRole('patient')) {
            return redirect()->route('patient.dashboard');
        } elseif (auth()->user()->hasRole('doctor')) {
            return redirect()->route('doctor.dashboard');
        } elseif (auth()->user()->hasRole('nurse')) {
            return redirect()->route('nurse.dashboard');
        } elseif (auth()->user()->hasRole('staff')) {
            return redirect()->route('staff.dashboard');
        }
        return redirect()->route('patient.dashboard');
    })->name('dashboard');

    // Admin routes
    Route::middleware(['role:admin|super-admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('billing', AdminBillController::class);
        Route::resource('payments', PaymentController::class);
        Route::get('payment-reports',[ PaymentController::class, 'report'])->name('payments.report');
        // Route::get('payment-reports',[ PaymentController::class, 'report'])->name('payments.report.export');
        Route::resource('departments', DepartmentController::class);
        // Staff Schedule routes
        Route::resource('staff-schedules', StaffScheduleController::class);
        
        // Inventory routes
        Route::resource('inventory', InventoryController::class);
        Route::post('inventory/{id}/adjust-stock', [InventoryController::class, 'adjustStock'])->name('inventory.adjust-stock');
        Route::get('inventory/export', [InventoryController::class, 'export'])->name('inventory.export');
    });

    Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/checkups', [CheckupController::class, 'index'])->name('checkups.index');
        Route::post('/checkups', [CheckupController::class, 'store'])->name('checkups.store');
        Route::get('/checkups/{checkup}', [CheckupController::class, 'show'])->name('checkups.show');
        Route::put('/checkups/{checkup}', [CheckupController::class, 'update'])->name('checkups.update');
        Route::get('/patients/search', [CheckupController::class, 'getPatients'])->name('patients.search');
        Route::resource('patient-assessments', HealthAssessmentController::class);
    });

    
    Route::middleware(['role:patient'])->prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::resource('prescriptions', PrescriptionController::class);
        Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
        Route::get('/bills/{bill}', [BillController::class, 'show'])->name('bills.show');
        Route::get('/bills/{bill}/download', [BillController::class, 'download'])->name('bills.download');
    });


    // Role-specific dashboard routes
    Route::get('/doctor/dashboard', [DashboardController::class, 'doctorDashboard'])
        ->name('doctor.dashboard')
        ->middleware('auth');

    Route::get('/nurse/dashboard', [DashboardController::class, 'nurseDashboard'])
        ->name('nurse.dashboard')
        ->middleware('auth');

    Route::get('/staff/dashboard', [DashboardController::class, 'staffDashboard'])
        ->name('staff.dashboard')
        ->middleware('auth');

    // Appointment Routes
    Route::resource('appointments', AppointmentController::class);
    Route::get('/doctor/{doctor}/schedule', [AppointmentController::class, 'getDoctorSchedule'])
        ->name('doctor.schedule');
    Route::get('/appointment/calendar', [AppointmentController::class, 'calendar'])->name('appointments.calendar');

    // Employee Routes
    Route::middleware(['auth'])->prefix('employee')->name('employee.')->group(function () {
        Route::get('/payroll', [EmployeePortalController::class, 'payroll'])->name('payroll');
        Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
        Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
        Route::get('/schedule', [EmployeePortalController::class, 'schedule'])->name('schedule');
        Route::get('/documents/payslips', [EmployeePortalController::class, 'payslips'])->name('documents.payslips');
        Route::get('/documents/contracts', [EmployeePortalController::class, 'contracts'])->name('documents.contracts');
        Route::get('/documents/tax-documents', [EmployeePortalController::class, 'taxDocuments'])->name('documents.tax-documents');
    });
});
