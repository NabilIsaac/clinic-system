<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Bill;
use App\Models\User;
use App\Models\Department;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function getDefaultData()
    {
        return [
            // Common data across all dashboards
            'todayAppointments' => collect(),
            'upcomingAppointments' => collect(),
            'appointments' => collect(),
            'recentPatients' => collect(),
            'prescriptions' => collect(),
            'bills' => collect(),
            'pendingBills' => collect(),
            
            // Admin specific data
            'totalUsers' => 0,
            'totalDoctors' => 0,
            'totalPatients' => 0,
            'completedAppointments' => 0,
            'activeDepartments' => collect(),
            'pendingRequests' => collect(),
            'weeklyAppointments' => [],
            'departmentStats' => collect(),
            'recentActivities' => collect(),
            'appointmentStatusStats' => [],
            'totalAppointments' => 0
        ];
    }

    public function patientDashboard()
    {
        $data = $this->getDefaultData();
        $patient = auth()->user()->patient;
        $now = now();

         // Get upcoming appointments (excluding the next appointment)
         $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_datetime', '>=', now())
            ->with(['doctor.user', 'department'])
            ->orderBy('appointment_datetime', 'desc')
            ->take(5)
            ->get();
            
        // Get next appointment (first upcoming appointment)
        $data['nextAppointment'] = $upcomingAppointments->first();
        $data['upcomingAppointments'] = $upcomingAppointments->slice(1);


        // Recent appointments (past appointments)
        $data['recentAppointments'] = Appointment::where('patient_id', $patient->id)
            ->where('appointment_datetime', '<=', $now)
            ->with(['doctor.user', 'department'])
            ->orderBy('appointment_datetime', 'desc')
            ->take(5)
            ->get();

        $data['prescriptions'] = $patient->prescriptions()
            ->with(['diagnosis', 'prescriptionDrugs.drug'])
            ->latest()
            ->take(5)
            ->get();

        $data['bills'] = Bill::where('patient_id', $patient->id)
            ->latest()
            ->take(5)
            ->get();

        return $data;
    }

    public function doctorDashboard()
    {
        // dd(auth()->user()->doctor);
        $data = $this->getDefaultData();
        $doctorEmployee = Employee::where('user_id', auth()->id())->first();
    
        if (!$doctorEmployee) {
            return redirect()->back()->with('error', 'Doctor profile not found.');
        }
        
        $data['todayAppointments'] = Appointment::where('doctor_id', $doctorEmployee->id)
            ->whereDate('appointment_datetime', Carbon::today())
            ->with(['patient.user', 'department'])
            ->orderBy('appointment_datetime')
            ->get();

        $data['upcomingAppointments'] = Appointment::where('doctor_id', $doctorEmployee->id)
            ->whereDate('appointment_datetime', '>', Carbon::today())
            ->with(['patient.user', 'department'])
            ->orderBy('appointment_datetime')
            ->take(5)
            ->get();

        $data['recentPatients'] = Patient::whereHas('appointments', function($query) use ($doctorEmployee) {
            $query->where('doctor_id', $doctorEmployee->id);
        })
        ->with('user')
        ->latest()
        ->take(5)
        ->get();

        return $data;
    }

    public function nurseDashboard()
    {
        $data = $this->getDefaultData();
        $nurse = auth()->user()->employee;
        $department = $nurse->department;

        $data['todayAppointments'] = Appointment::where('department_id', $department->id)
            ->whereDate('appointment_datetime', Carbon::today())
            ->with(['patient.user', 'doctor.user'])
            ->orderBy('appointment_datetime')
            ->get();

        return $data;
    }

    protected function receptionistDashboard()
    {
        $data = $this->getDefaultData();
        $now = now();
        $today = now()->startOfDay();

        // Today's appointments
        $data['todayAppointments'] = Appointment::whereDate('appointment_datetime', $today)
            ->count();

        // Pending appointments
        $data['pendingAppointments'] = Appointment::where('status', 'scheduled')
            ->where('appointment_datetime', '>=', $now)
            ->count();

        // Total patients
        $data['totalPatients'] = Patient::count();

        // Available doctors today
        $data['availableDoctors'] = Employee::whereHas('user', function($query) {
            $query->whereHas('roles', function($q) {
                $q->where('name', 'doctor');
            });
        })->count();

        // Today's schedule
        $data['todaySchedule'] = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDate('appointment_datetime', $today)
            ->orderBy('appointment_datetime', 'asc')
            ->get();

        return $data;
    }

    public function staffDashboard()
    {
        $data = $this->getDefaultData();

        $data['todayAppointments'] = Appointment::whereDate('appointment_datetime', Carbon::today())
            ->with(['patient.user', 'doctor.user', 'department'])
            ->orderBy('appointment_datetime')
            ->get();

        $data['pendingBills'] = Bill::where('status', 'pending')
            ->with(['patient.user'])
            ->latest()
            ->take(5)
            ->get();

        return $data;
    }

    public function adminDashboard()
    {
        $data = $this->getDefaultData();
        
        $data['totalUsers'] = User::count();
        $data['todayAppointments'] = Appointment::whereDate('appointment_datetime', Carbon::today())->get();
        $data['activeDepartments'] = Department::where('is_active', true)->get();
        $data['pendingRequests'] = Appointment::where('status', 'pending')->get();
        $data['totalDoctors'] = User::role('doctor')->count();
        $data['totalPatients'] = User::role('patient')->count();
        $data['completedAppointments'] = Appointment::where('status', 'completed')->count();
        
        // Weekly Appointments Trend
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
            
        $data['weeklyAppointments'] = array_merge($dates->toArray(), $weeklyAppointments);

        // Department Statistics
        $data['departmentStats'] = Department::where('is_active', true)
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

        // Recent Activities
        $data['recentActivities'] = Appointment::with(['patient.user', 'doctor.user', 'department'])
            ->latest('appointment_datetime')
            ->take(10)
            ->get()
            ->map(function ($appointment) {
                return [
                    'user' => optional($appointment->patient->user)->name ?? 'Unknown Patient',
                    'doctor' => optional($appointment->doctor->user)->name ?? 'Unknown Doctor',
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

        $defaultStatuses = ['pending' => 0, 'completed' => 0, 'cancelled' => 0];
        $data['appointmentStatusStats'] = array_merge($defaultStatuses, $appointmentStatusStats);
        $data['totalAppointments'] = array_sum($data['appointmentStatusStats']);

        return $data;
    }

    public function index($prefix)
    {
        if (!auth()->user()->hasRole($prefix)) {
            return redirect()->route('dashboard', ['prefix' => auth()->user()->roles->first()->name]);
        }

        $data = $this->getDashboardData($prefix);
        $data['currentRole'] = $prefix;
        
        return view('dashboard', $data);
    }

    private function getDashboardData($role)
    {
        $data = [];
        
        switch ($role) {
            case 'admin':
            case 'super-admin':
                $data = $this->adminDashboard();
                break;
            case 'doctor':
                $data = $this->doctorDashboard();
                break;
            case 'nurse':
                $data = $this->nurseDashboard();
                break;
            case 'receptionist':
                $data = $this->receptionistDashboard();
                break;
            case 'patient':
                $data = $this->patientDashboard();
                break;
            default:
                $data = $this->staffDashboard();
        }

        return $data;
    }
}