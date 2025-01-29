<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Auth::routes();

// Home Route
// Route::get('/home', [HomeController::class, 'index'])->name('home');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Admin\UsersController::class);
    });

    // Patient routes
    Route::prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
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
});
