<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckupRequest extends FormRequest
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
            'patient_id' => 'required|exists:users,id',
            'reason' => 'required|string|in:knee_pain,back_pain,shoulder_pain,neck_pain',
            'bp' => 'nullable|string',
            'visit_history' => 'nullable|string',
            'additional_comments' => 'nullable|string',
            
            // Medications
            'medications' => 'nullable|array',
            'medications.*.drug_id' => 'required|exists:drugs,id',
            'medications.*.quantity' => 'required|integer|min:1',
            'medications.*.dosage' => 'required|string',
            
            // Products
            'products' => 'nullable|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',

            'medications_total' => 'required|numeric|min:0',
            'products_total' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Please select a patient',
            'reason.required' => 'Please select a reason for the visit',
            'medications.*.drug_id.required' => 'Please select a medicine',
            'medications.*.quantity.required' => 'Please specify the medication quantity',
            'medications.*.dosage.required' => 'Please specify the medication dosage',
            'products.*.product_id.required' => 'Please select a product',
            'products.*.quantity.required' => 'Please specify the product quantity',
        ];
    }
}
