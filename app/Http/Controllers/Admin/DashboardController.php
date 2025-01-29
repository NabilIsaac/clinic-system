<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!auth()->user()->hasAnyRole(['admin', 'super-admin'])) {
            abort(403);
        }

        // Basic Analytics
        $totalUsers = User::count();
        $todayAppointments = Appointment::whereDate('appointment_datetime', Carbon::today())->count();
        $activeDepartments = Department::where('is_active', true)->count();
        $pendingRequests = Appointment::where('status', 'pending')->count();

        // Role-based Analytics
        $totalDoctors = User::role('doctor')->count();
        $totalPatients = User::role('patient')->count();
        $completedAppointments = Appointment::where('status', 'completed')->count();
        
        // Weekly Appointments Trend (initialize with zeros)
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates->put($date, 0);
        }
        
        $weeklyAppointments = Appointment::select(DB::raw('DATE(appointment_datetime) as date'), DB::raw('count(*) as total'))
            ->whereBetween('appointment_datetime', [Carbon::now()->subDays(7), Carbon::now()])
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();
            
        $weeklyAppointments = array_merge($dates->toArray(), $weeklyAppointments);

        // Department Statistics
        $departmentStats = Department::where('is_active', true)
            ->get()
            ->map(function ($dept) {
                $doctorCount = User::role('doctor')->where('department_id', $dept->id)->count();
                $appointmentCount = Appointment::where('department_id', $dept->id)->count();
                
                return [
                    'name' => $dept->name,
                    'doctors' => $doctorCount,
                    'appointments' => $appointmentCount,
                    'percentage' => $appointmentCount > 0 ? ($appointmentCount / Appointment::count()) * 100 : 0
                ];
            });

        // Recent Activities (last 10)
        $recentActivities = Appointment::with(['patient', 'doctor', 'department'])
            ->latest('appointment_datetime')
            ->take(10)
            ->get()
            ->map(function ($appointment) {
                return [
                    'user' => optional($appointment->patient)->name ?? 'Unknown Patient',
                    'doctor' => optional($appointment->doctor)->name ?? 'Unknown Doctor',
                    'department' => optional($appointment->department)->name ?? 'Unknown Department',
                    'date' => Carbon::parse($appointment->appointment_datetime)->format('M d, Y h:i A'),
                    'status' => ucfirst($appointment->status ?? 'unknown')
                ];
            });

        // Appointment Status Distribution
        $appointmentStatusStats = Appointment::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        // Ensure all possible statuses are represented
        $defaultStatuses = ['pending' => 0, 'completed' => 0, 'cancelled' => 0];
        $appointmentStatusStats = array_merge($defaultStatuses, $appointmentStatusStats);

        $totalAppointments = array_sum($appointmentStatusStats);

        return view('admin.dashboard', compact(
            'totalUsers',
            'todayAppointments',
            'activeDepartments',
            'pendingRequests',
            'totalDoctors',
            'totalPatients',
            'completedAppointments',
            'weeklyAppointments',
            'departmentStats',
            'recentActivities',
            'appointmentStatusStats',
            'totalAppointments'
        ));
    }
}
