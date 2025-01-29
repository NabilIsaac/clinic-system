<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class AppointmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],
            'doctor_id' => ['required', 'exists:employees,id'],
            'patient_id' => [
                'required_if:role,staff,admin',
                'exists:patients,id'
            ],
            'appointment_date' => [
                'required',
                'date',
                'after_or_equal:' . Carbon::today()->format('Y-m-d')
            ],
            'appointment_time' => ['required', 'date_format:H:i'],
            'reason' => ['required', 'string', 'max:500'],
            'status' => ['sometimes', 'in:scheduled,completed,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->filled('patient_id') && auth()->user()->hasRole('patient')) {
            $this->merge([
                'patient_id' => auth()->user()->patient->id
            ]);
        }
    }

    public function messages()
    {
        return [
            'appointment_date.after_or_equal' => 'The appointment date must be today or a future date.',
            'appointment_time.date_format' => 'The appointment time must be in 24-hour format (HH:MM).',
        ];
    }
}
