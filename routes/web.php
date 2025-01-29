<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Auth::routes();

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->hasRole('patient')) {
            return redirect()->route('patient.dashboard');
        } elseif (auth()->user()->hasRole('doctor')) {
            return redirect()->route('doctor.dashboard');
        } elseif (auth()->user()->hasRole('nurse')) {
            return redirect()->route('nurse.dashboard');
        } elseif (auth()->user()->hasRole('staff')) {
            return redirect()->route('staff.dashboard');
        } elseif (auth()->user()->hasRole('super-admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // Role-specific dashboard routes
    Route::get('/patient/dashboard', [DashboardController::class, 'patientDashboard'])
        ->name('patient.dashboard')
        ->middleware('role:patient');

    Route::get('/doctor/dashboard', [DashboardController::class, 'doctorDashboard'])
        ->name('doctor.dashboard')
        ->middleware('role:doctor');

    Route::get('/nurse/dashboard', [DashboardController::class, 'nurseDashboard'])
        ->name('nurse.dashboard')
        ->middleware('role:nurse');

    Route::get('/staff/dashboard', [DashboardController::class, 'staffDashboard'])
        ->name('staff.dashboard')
        ->middleware('role:staff');

    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])
        ->name('admin.dashboard')
        ->middleware('role:super-admin');

    // Appointment Routes
    Route::resource('appointments', AppointmentController::class);
    Route::get('/doctor/{doctor}/schedule', [AppointmentController::class, 'getDoctorSchedule'])
        ->name('doctor.schedule');
});

// Home Route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
