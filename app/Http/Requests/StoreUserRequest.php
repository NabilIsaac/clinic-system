<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
            'department_id' => 'required|exists:departments,id',
            'phone_number' => 'required|string',
            'gender' => 'nullable|string',
            'occupation' => 'nullable|string',
            'marital_status' => 'nullable|string',
            'address' => 'required|string',
            'date_of_birth' => 'nullable|date',
            'joining_date' => 'required',
            'salary' => 'required|numeric|min:0',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_branch' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string',
            'relationship' => 'nullable|string',
            // 'qualifications' => 'nullable|string',
            // 'specialization' => 'nullable|string',
        ];
    }
}
