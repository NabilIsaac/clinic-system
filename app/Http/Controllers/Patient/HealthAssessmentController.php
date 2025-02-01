<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\PatientHealthInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthAssessmentController extends Controller
{
    public function index()
    {
        $assessments = PatientHealthInfo::with(['patient', 'assessment'])
            ->latest()
            ->paginate(15);
        return view('patient.assessments.index', compact('assessments'));
    }

    public function create()
    {
        $patients = User::role('patient')->get();
        return view('patient.assessments.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'disease_type' => 'required|in:spine,stroke,hip,shoulder',
            'hpt_dm' => 'required|string',
            'pc' => 'required|string',
            'pain_scale' => 'required|numeric|min:0|max:10',
            'pain_location' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $healthInfo = PatientHealthInfo::create($request->only([
                'patient_id',
                'disease_type',
                'hpt_dm',
                'pc',
                'pain_scale',
                'pain_location'
            ]));

            // Create specific assessment based on disease type
            $this->createAssessment($healthInfo, $request);

            DB::commit();
            return redirect()->route('patient-assessments.show', $healthInfo)
                ->with('success', 'Assessment created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating assessment: ' . $e->getMessage());
        }
    }

    private function createAssessment(PatientHealthInfo $healthInfo, Request $request)
    {
        $assessmentData = $request->input($healthInfo->disease_type);
        
        switch($healthInfo->disease_type) {
            case 'spine':
                $healthInfo->assessment()->create([
                    'history' => $assessmentData['history'],
                    'previous_treatment' => $assessmentData['previous_treatment'],
                    'pain_scale' => $assessmentData['pain_scale'],
                    'pain_location' => $assessmentData['pain_location'],
                ]);
                break;
            case 'stroke':
                $healthInfo->assessment()->create([
                    'type' => $assessmentData['type'],
                    'time_since' => $assessmentData['time_since'],
                    'affected_side' => $assessmentData['affected_side'],
                    'mobility_status' => $assessmentData['mobility_status'],
                ]);
                break;
            case 'hip':
                $healthInfo->assessment()->create([
                    'condition_type' => $assessmentData['condition_type'],
                    'rom' => $assessmentData['rom'],
                    'weight_bearing' => $assessmentData['weight_bearing'],
                ]);
                break;
            case 'shoulder':
                $healthInfo->assessment()->create([
                    'condition_type' => $assessmentData['condition_type'],
                    'movements' => $assessmentData['movements'],
                    'pain_characteristics' => $assessmentData['pain_characteristics'],
                ]);
                break;
        }
    }

    public function show(PatientHealthInfo $patientAssessment)
    {
        $patientAssessment->load(['patient', 'assessment']);
        return view('patient.assessments.show', compact('patientAssessment'));
    }
}