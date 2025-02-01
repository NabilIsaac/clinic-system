<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Checkup;
use App\Models\User;
use Illuminate\Http\Request;

class CheckupController extends Controller
{
    public function index()
    {
        $checkups = auth()->user()->doctorCheckups()
            ->with(['patient', 'procedures'])
            ->latest()
            ->paginate(10);

        return view('doctor.checkups.index', compact('checkups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'symptoms' => 'required|array',
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
            'procedures' => 'nullable|array',
            'procedures.*.name' => 'required|string',
            'procedures.*.description' => 'nullable|string',
            'procedures.*.cost' => 'required|numeric|min:0',
            'procedures.*.notes' => 'nullable|string',
        ]);

        $checkup = Checkup::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => auth()->id(),
            'symptoms' => $validated['symptoms'],
            'diagnosis' => $validated['diagnosis'],
            'notes' => $validated['notes'],
            'date' => now(),
            'status' => 'in-progress'
        ]);

        if (!empty($validated['procedures'])) {
            foreach ($validated['procedures'] as $procedure) {
                $checkup->procedures()->create($procedure);
            }
        }

        return response()->json([
            'message' => 'Checkup created successfully',
            'checkup' => $checkup->load('procedures', 'patient')
        ]);
    }

    public function show(Checkup $checkup)
    {
        $checkup->load(['patient', 'procedures', 'prescription']);
        return view('doctor.checkups.show', compact('checkup'));
    }

    public function update(Request $request, Checkup $checkup)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in-progress,completed,cancelled',
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $checkup->update($validated);

        return response()->json([
            'message' => 'Checkup updated successfully',
            'checkup' => $checkup->fresh()
        ]);
    }

    public function getPatients(Request $request)
    {
        $search = $request->get('search');
        
        $patients = User::role('patient')
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->take(5)
            ->get(['id', 'name', 'email']);

        return response()->json($patients);
    }
}