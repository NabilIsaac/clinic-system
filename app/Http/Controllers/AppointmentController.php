<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\AppointmentRequest;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query();

        if (auth()->user()->hasRole('patient')) {
            $query->where('patient_id', auth()->user()->patient->id);
        } elseif (auth()->user()->hasRole('doctor')) {
            $query->where('doctor_id', auth()->user()->employee->id);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        $appointments = $query->with(['patient.user', 'doctor.user', 'department'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(10);

        $departments = Department::all();

        return view('appointments.index', compact('appointments', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        $doctors = Employee::role('doctor')->with('user')->get();
        
        return view('appointments.create', compact('departments', 'doctors'));
    }

    public function store(AppointmentRequest $request)
    {
        $appointment = new Appointment($request->validated());
        
        if (auth()->user()->hasRole('patient')) {
            $appointment->patient_id = auth()->user()->patient->id;
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
        $doctors = Employee::role('doctor')->with('user')->get();
        
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

    public function getDoctorSchedule(Request $request, Employee $doctor)
    {
        $date = Carbon::parse($request->date);
        
        $schedule = $doctor->weeklySchedules()
            ->where('day_of_week', $date->dayOfWeek)
            ->first();

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $date)
            ->pluck('appointment_time');

        return response()->json([
            'schedule' => $schedule,
            'bookedSlots' => $appointments
        ]);
    }
}
