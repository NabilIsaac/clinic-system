<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Bill;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function patientDashboard()
    {
        $patient = auth()->user()->patient;
        
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor.user', 'department'])
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();

        $prescriptions = $patient->prescriptions()
            ->with(['diagnosis', 'prescriptionDrugs.drug'])
            ->latest()
            ->take(5)
            ->get();

        $bills = Bill::where('patient_id', $patient->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.patient', compact('appointments', 'prescriptions', 'bills'));
    }

    public function doctorDashboard()
    {
        $doctor = auth()->user()->employee;
        
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', Carbon::today())
            ->with(['patient.user', 'department'])
            ->orderBy('appointment_time')
            ->get();

        $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', '>', Carbon::today())
            ->with(['patient.user', 'department'])
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        $recentPatients = Patient::whereHas('appointments', function($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })
        ->with('user')
        ->latest()
        ->take(5)
        ->get();

        return view('dashboard.doctor', compact('todayAppointments', 'upcomingAppointments', 'recentPatients'));
    }

    public function nurseDashboard()
    {
        $nurse = auth()->user()->employee;
        $department = $nurse->department;

        $todayAppointments = Appointment::where('department_id', $department->id)
            ->whereDate('appointment_date', Carbon::today())
            ->with(['patient.user', 'doctor.user'])
            ->orderBy('appointment_time')
            ->get();

        return view('dashboard.nurse', compact('todayAppointments'));
    }

    public function staffDashboard()
    {
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())
            ->with(['patient.user', 'doctor.user', 'department'])
            ->orderBy('appointment_time')
            ->get();

        $pendingBills = Bill::where('status', 'pending')
            ->with(['patient.user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.staff', compact('todayAppointments', 'pendingBills'));
    }

    public function adminDashboard()
    {
        $totalPatients = Patient::count();
        $totalAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $pendingBills = Bill::where('status', 'pending')->count();
        
        $recentAppointments = Appointment::with(['patient.user', 'doctor.user', 'department'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('totalPatients', 'totalAppointments', 'pendingBills', 'recentAppointments'));
    }
}
