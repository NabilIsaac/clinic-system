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
use App\Http\Controllers\Doctor\ExcuseDutyController;
use App\Http\Controllers\Doctor\ReferralFormController;
use App\Http\Controllers\Doctor\RequestFormController;
use App\Http\Controllers\Doctor\PatientController as DoctorPatientController;
use App\Http\Controllers\Patient\HealthAssessmentController;
use App\Http\Controllers\Admin\PayslipController;

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
        $role = auth()->user()->roles->first()->name;
        return redirect()->route('dashboard', ['prefix' => $role]);
    });

    // Single dashboard route with dynamic prefix
    Route::get('{prefix}/dashboard', [DashboardController::class, 'index'])
        ->where('prefix', 'super-admin|admin|patient|doctor|nurse|staff')
        ->name('dashboard');

    Route::post('/switch-role', [App\Http\Controllers\UserController::class, 'switchRole'])
    ->name('user.switch-role');

    // Admin routes
    Route::middleware(['role:admin|super-admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class);

        Route::resource('billing', AdminBillController::class);
        Route::get('/billing/patient-items/{patient}', [AdminBillController::class, 'getPatientItems'])
        ->name('admin.billing.patient-items');

        Route::resource('payments', PaymentController::class)->only(['index', 'show', 'destroy']);
        Route::get('/payments/create/{billing}', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments/store/{billing}', [PaymentController::class, 'store'])->name('payments.store');
        // Route::post('/payments/show/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::patch('payments/{payment}/void', [PaymentController::class, 'void'])->name('payments.void');
        Route::get('payment-reports',[ PaymentController::class, 'report'])->name('payments.report');
        // Route::get('payment-reports',[ PaymentController::class, 'report'])->name('payments.report.export');

        Route::resource('departments', DepartmentController::class);

        // Staff Schedule routes
        Route::resource('staff-schedules', StaffScheduleController::class);

        Route::resource('payslips', PayslipController::class);
        Route::get('/payslips/bulk-create', [PayslipController::class, 'bulkCreate'])->name('payslips.bulk-create');
        Route::post('payslips/bulk-store', [PayslipController::class, 'bulkStore'])->name('payslips.bulk-store');
        Route::get('payslips/{payslip}/download', [PayslipController::class, 'downloadPDF'])->name('payslips.download');
        
        // Inventory routes
        Route::resource('inventory', InventoryController::class);
        Route::post('inventory/{id}/adjust-stock', [InventoryController::class, 'adjustStock'])->name('inventory.adjust-stock');
        Route::get('inventory/export', [InventoryController::class, 'export'])->name('inventory.export');
    });

    Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
        Route::resource('patients', DoctorPatientController::class)->only(['index', 'show']);
        Route::resource('excuse-duty', ExcuseDutyController::class);
        Route::resource('referral-forms', ReferralFormController::class);
        Route::resource('request-forms', RequestFormController::class);
        Route::resource('checkups', CheckupController::class);
        Route::get('/patients/search', [CheckupController::class, 'getPatients'])->name('patients.search');
        Route::resource('patient-assessments', HealthAssessmentController::class);
    });

    Route::middleware(['role:nurse|receptionist'])->prefix('nurse')->name('nurse.')->group(function () {
        Route::resource('patients', DoctorPatientController::class);
        Route::resource('checkups', CheckupController::class);
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
        Route::post('payslips/{payslip}/issue', [PayslipController::class, 'issue'])->name('payslips.issue');
        Route::get('/documents/contracts', [EmployeePortalController::class, 'contracts'])->name('documents.contracts');
        Route::get('/documents/tax-documents', [EmployeePortalController::class, 'taxDocuments'])->name('documents.tax-documents');
    });
});
