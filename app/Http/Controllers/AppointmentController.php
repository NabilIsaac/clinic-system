<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AppointmentRequest;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query();

        if (auth()->user()->hasRole('patient')) {
            $query->whereHas('patient', function($q) {
                $q->where('user_id', auth()->id());
            });
        } elseif (auth()->user()->hasRole('doctor')) {
            $query->whereHas('doctor', function($q) {
                $q->where('user_id', auth()->id());
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('appointment_datetime', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('appointment_datetime', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        $appointments = $query->with(['patient.user', 'doctor.user', 'department'])
            ->orderBy('appointment_datetime')
            ->paginate(10);

        $departments = Department::all();

        return view('appointments.index', compact('appointments', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        $doctors = User::role('doctor')->with('employee')->get()
            ->map(function ($user) {
                return [
                    'id' => $user->employee->id,
                    'name' => $user->name,
                    'department' => $user->employee->department->name ?? '',
                    'specialization' => $user->employee->specialization ?? ''
                ];
            });

        $patients = User::role('patient')
            ->with('patient')
            ->whereHas('patient')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->patient->id,
                    'name' => $user->name
                ];
            });
        return view('appointments.create', compact('departments', 'doctors', 'patients'));
    }

    public function store(AppointmentRequest $request)
    {
        $appointment = new Appointment($request->validated());

        if (auth()->user()->hasRole('patient')) {
            $patient = Patient::where('user_id', auth()->id())->first();
            $appointment->patient_id = $patient->id;
        } elseif (auth()->user()->hasRole('doctor')) {
            $doctorEmployee = Employee::where('user_id', auth()->id())->first();
            $appointment->doctor_id = $doctorEmployee->id;
        }

        $appointment->save();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);

        $appointment->load(['patient.user', 'doctor.user', 'department']);
        
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $departments = Department::all();
        $doctors = User::role('doctor')->with('employee')->get()
            ->map(function ($user) {
                return [
                    'id' => $user->employee->id,
                    'name' => $user->name,
                    'department' => $user->employee->department->name ?? '',
                    'specialization' => $user->employee->specialization ?? ''
                ];
            });
        
        return view('appointments.edit', compact('appointment', 'departments', 'doctors'));
    }

    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $appointment->update($request->validated());

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }

    public function getDoctorSchedule(Request $request, User $doctor)
    {
        $date = Carbon::parse($request->date);
        
        $schedule = $doctor->employee->weeklySchedules()
            ->where('day_of_week', $date->dayOfWeek)
            ->first();

        $appointments = Appointment::where('doctor_id', $doctor->employee->id)
            ->whereDate('appointment_datetime', $date)
            ->pluck('appointment_time');

        return response()->json([
            'schedule' => $schedule,
            'bookedSlots' => $appointments
        ]);
    }

    public function calendar(Request $request)
    {
        $query = Appointment::query();
        $view = $request->get('view', '3days');
        $selectedDate = $request->get('date') ? Carbon::parse($request->date) : now();

        if (auth()->user()->hasRole('patient')) {
            $query->whereHas('patient', function($q) {
                $q->where('user_id', auth()->id());
            });
        } elseif (auth()->user()->hasRole('doctor')) {
            $query->whereHas('doctor', function($q) {
                $q->where('user_id', auth()->id());
            });
        }

        // Calculate date range based on view
        switch ($view) {
            case 'day':
                $startDate = $selectedDate->copy()->startOfDay();
                $endDate = $selectedDate->copy()->endOfDay();
                $days = collect([$selectedDate]);
                break;
            case 'week':
                $startDate = $selectedDate->copy()->startOfWeek();
                $endDate = $selectedDate->copy()->endOfWeek();
                $days = collect(range(0, 6))->map(fn($i) => $startDate->copy()->addDays($i));
                break;
            case 'month':
                $startDate = $selectedDate->copy()->startOfMonth();
                $endDate = $selectedDate->copy()->endOfMonth();
                $days = collect(range(0, $endDate->daysInMonth - 1))
                    ->map(fn($i) => $startDate->copy()->addDays($i));
                break;
            default: // 3days
                $startDate = $selectedDate->copy()->startOfDay();
                $endDate = $selectedDate->copy()->addDays(2)->endOfDay();
                $days = collect(range(0, 2))->map(fn($i) => $selectedDate->copy()->addDays($i));
                break;
        }

        // Debug information
        \Log::info('Calendar Debug', [
            'view' => $view,
            'selectedDate' => $selectedDate->format('Y-m-d'),
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'days' => $days->map(fn($d) => $d->format('Y-m-d'))->toArray()
        ]);

        $appointments = $query->whereBetween('appointment_datetime', [$startDate, $endDate])
            ->with(['patient.user', 'doctor.user', 'department'])
            ->get()
            ->map(function($appointment) {
                // Ensure appointment_datetime is used for start_time if start_time is not set
                if (!$appointment->start_time || $appointment->start_time->format('H:i:s') === '00:00:00') {
                    $appointment->start_time = $appointment->appointment_datetime;
                }
                // Set end_time to 1 hour after start if not set
                if (!$appointment->end_time || $appointment->end_time->format('H:i:s') === '00:00:00') {
                    $appointment->end_time = $appointment->start_time->copy()->addHour();
                }
                return $appointment;
            });

        // Debug appointments
        \Log::info('Appointments Debug', [
            'count' => $appointments->count(),
            'appointments' => $appointments->map(function($apt) {
                return [
                    'id' => $apt->id,
                    'datetime' => $apt->appointment_datetime->format('Y-m-d H:i:s'),
                    'start' => $apt->start_time->format('H:i:s'),
                    'end' => $apt->end_time->format('H:i:s'),
                    'patient' => $apt->patient->user->name ?? 'N/A',
                    'doctor' => $apt->doctor->user->name ?? 'N/A'
                ];
            })->toArray()
        ]);

        return view('appointments.calendar', [
            'appointments' => $appointments,
            'selectedDate' => $selectedDate,
            'view' => $view,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'days' => $days,
            'isMonthView' => $view === 'month'
        ]);
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'scheduled' => '#3490dc', // blue
            'completed' => '#38c172', // green
            'cancelled' => '#e3342f', // red
            default => '#6c757d' // gray
        };
    }
}
