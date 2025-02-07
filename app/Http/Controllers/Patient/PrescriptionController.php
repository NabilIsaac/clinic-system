<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use PDF;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::where('patient_id', auth()->id())
            ->with(['doctor', 'medications'])
            ->latest()
            ->paginate(10);

        return view('patient.prescriptions.index', compact('prescriptions'));
    }

    public function show(Prescription $prescription)
    {
        // $this->authorize('view', $prescription);
        return view('patient.prescriptions.show', compact('prescription'));
    }

    public function download(Prescription $prescription)
    {
        // $this->authorize('view', $prescription);
        
        $pdf = PDF::loadView('patient.prescriptions.pdf', compact('prescription'));
        return $pdf->download('prescription-' . $prescription->id . '.pdf');
    }
}