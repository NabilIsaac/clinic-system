<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = auth()->user()->prescriptions()
            ->with(['prescriptionDrugs.drug', 'diagnosis', 'doctor.user'])
            ->latest()
            ->paginate(10);

        return view('patient.prescriptions.index', compact('prescriptions'));
    }

    public function show(Prescription $prescription)
    {
        if ($prescription->patient_id !== auth()->id()) {
            abort(403);
        }

        $prescription->load(['prescriptionDrugs.drug', 'diagnosis', 'doctor.user']);
        return view('patient.prescriptions.show', compact('prescription'));
    }

    public function download(Prescription $prescription)
    {
        if ($prescription->patient_id !== auth()->id()) {
            abort(403);
        }

        // Generate PDF and return for download
        $pdf = PDF::loadView('patient.prescriptions.pdf', compact('prescription'));
        return $pdf->download('prescription-' . $prescription->id . '.pdf');
    }
}