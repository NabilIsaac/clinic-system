<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // dd(Patient::get());
        $query = Patient::query()
            ->whereHas('appointments', function ($query) {
                $query->where('doctor_id', Auth::id());
            })
            ->with(['user', 'appointments' => function ($query) {
                $query->where('doctor_id', Auth::id())
                    ->latest();
            }]);

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%")
                    ->orWhere('phone', 'like', "%{$searchTerm}%");
            })
            ->orWhere('medical_record_number', 'like', "%{$searchTerm}%");
        }

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->whereHas('appointments', function ($query) use ($request) {
                $query->where('status', $request->status)
                    ->where('doctor_id', Auth::id());
            });
        }

        $patients = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('doctor.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('doctor.patients.create');
    }

    public function store(StorePatientRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(Str::random(10)), // Generate a random password
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
                'address' => $request->address,
            ]);

            $user->assignRole('patient');

            // Create patient
            $patient = Patient::create([
                'user_id' => $user->id,
                'blood_type' => $request->blood_type,
                'weight' => $request->weight,
                'height' => $request->height,
                'bmi' => $request->bmi,
                'allergies' => $request->allergies,
                'chronic_diseases' => $request->chronic_diseases,
                'medical_history' => $request->medical_history,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'emergency_contact_relation' => $request->emergency_contact_relation,
                'insurance_company' => $request->insurance_company,
                'insurance_number' => $request->insurance_number,
                'policy_number' => $request->policy_number,
                // 'member_number' => $request->member_number,
                'issued_date' => $request->issued_date,
                'expiry_date' => $request->expiry_date,
            ]);

            DB::commit();

            // Send password reset link to patient's email
            // $status = Password::sendResetLink(['email' => $user->email]);

            return redirect()->route('receptionist.patients.index')
                ->with('success', 'Patient created successfully. A password reset link has been sent to their email.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while creating the patient.');
        }
    }

    public function show(Patient $patient)
    {
        // Ensure the doctor has access to this patient
        $hasAccess = $patient->appointments()
            ->where('doctor_id', Auth::id())
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Unauthorized access to patient records.');
        }

        $patient->load(['user', 'appointments' => function ($query) {
            $query->where('doctor_id', Auth::id())
                ->with(['checkup', 'assessments'])
                ->latest();
        }]);

        return view('doctor.patients.show', compact('patient'));
    }
}