<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if (!$user->hasRole('patient')) {
            abort(403);
        }

        $appointments = $user->patientAppointments()
            ->with(['doctor.user', 'department'])
            ->latest('appointment_datetime')
            ->take(5)
            ->get();

        $prescriptions = $user->prescriptions()
            ->with(['prescriptionDrugs.drug', 'diagnosis'])
            ->latest()
            ->take(3)
            ->get();

        $bills = $user->bills()
            ->latest()
            ->take(5)
            ->get();

        return view('patient.dashboard', compact('appointments', 'prescriptions', 'bills'));
    }
}
