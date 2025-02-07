<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\ExcuseDuty;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExcuseDutyController extends Controller
{
    public function index()
    {
        $excuseDuties = ExcuseDuty::where('doctor_id', auth()->id())
            ->with(['patient'])
            ->latest()
            ->paginate(10);

        return view('doctor.excuse-duties.index', compact('excuseDuties'));
    }

    public function create()
    {
        $patients = User::role('patient')->get();
        return view('doctor.excuse-duties.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        $validated['doctor_id'] = auth()->id();
        $validated['status'] = 'issued';

        ExcuseDuty::create($validated);

        return redirect()
            ->route('doctor.excuse-duties.index')
            ->with('success', 'Excuse duty has been generated successfully.');
    }

    public function show(ExcuseDuty $excuseDuty)
    {
        $this->authorize('view', $excuseDuty);
        return view('doctor.excuse-duties.show', compact('excuseDuty'));
    }

    public function cancel(ExcuseDuty $excuseDuty)
    {
        $this->authorize('update', $excuseDuty);
        
        $excuseDuty->update(['status' => 'cancelled']);

        return redirect()
            ->route('doctor.excuse-duties.index')
            ->with('success', 'Excuse duty has been cancelled.');
    }
}