<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'address' => 'nullable|string',
            // 'blood_type' => 'nullable|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            // 'weight' => 'nullable|numeric',
            // 'height' => 'nullable|numeric',
            // 'bmi' => 'nullable|numeric',
            // 'allergies' => 'nullable|string',
            // 'chronic_diseases' => 'nullable|string',
            // 'medical_history' => 'nullable|string',
            // 'emergency_contact_name' => 'nullable|string|max:255',
            // 'emergency_contact_phone' => 'nullable|string|max:20',
            // 'emergency_contact_relation' => 'nullable|string|max:255',
            // 'insurance_company' => 'nullable|string|max:255',
            // 'insurance_number' => 'nullable|string|max:255',
            // 'issued_date' => 'nullable|date',
            // 'expiry_date' => 'nullable|date|after:issued_date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The patient name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'phone_number.required' => 'Phone number is required.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.date' => 'Please enter a valid date.',
            'gender.required' => 'Gender is required.',
            'gender.in' => 'Please select a valid gender option.',
            'marital_status.required' => 'Marital status is required.',
            'marital_status.in' => 'Please select a valid marital status.',
            'weight.numeric' => 'Weight must be a number.',
            'height.numeric' => 'Height must be a number.',
            'bmi.numeric' => 'BMI must be a number.',
            'expiry_date.after' => 'Expiry date must be after the issue date.',
        ];
    }
}
