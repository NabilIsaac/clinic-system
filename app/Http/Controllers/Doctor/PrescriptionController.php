<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::where('doctor_id', auth()->id())
            ->with(['patient'])
            ->latest()
            ->paginate(10);

        return view('doctor.prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $patients = User::role('patient')->get();
        return view('doctor.prescriptions.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
            'medications' => 'required|array|min:1',
            'medications.*.medication_name' => 'required|string',
            'medications.*.dosage' => 'required|string',
            'medications.*.frequency' => 'required|string',
            'medications.*.duration' => 'required|integer|min:1',
            'medications.*.duration_unit' => 'required|in:days,weeks,months',
            'medications.*.special_instructions' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $prescription = Prescription::create([
                'patient_id' => $validated['patient_id'],
                'doctor_id' => auth()->id(),
                'diagnosis' => $validated['diagnosis'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'active'
            ]);

            foreach ($validated['medications'] as $medication) {
                $prescription->medications()->create($medication);
            }
        });

        return redirect()
            ->route('doctor.prescriptions.index')
            ->with('success', 'Prescription created successfully');
    }

    public function show(Prescription $prescription)
    {
        // $this->authorize('view', $prescription);
        return view('doctor.prescriptions.show', compact('prescription'));
    }

    public function cancel(Prescription $prescription)
    {
        $this->authorize('update', $prescription);
        
        $prescription->update(['status' => 'cancelled']);

        return redirect()
            ->route('doctor.prescriptions.index')
            ->with('success', 'Prescription cancelled successfully');
    }
}