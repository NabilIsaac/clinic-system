<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = auth()->user()->patientAppointments()
            ->with(['doctor.user', 'department'])
            ->latest('appointment_datetime')
            ->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->patient_id !== auth()->id()) {
            abort(403);
        }

        $appointment->load(['doctor.user', 'department', 'checkup']);
        return view('patient.appointments.show', compact('appointment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'appointment_datetime' => 'required|date|after:today',
            'reason' => 'required|string|max:500',
        ]);

        $appointment = auth()->user()->patientAppointments()->create([
            'doctor_id' => $validated['doctor_id'],
            'department_id' => $validated['department_id'],
            'appointment_datetime' => $validated['appointment_datetime'],
            'reason' => $validated['reason'],
            'status' => 'pending'
        ]);

        return redirect()->route('patient.appointments.show', $appointment)
            ->with('success', 'Appointment scheduled successfully.');
    }
}