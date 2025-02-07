@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="p-6">
        <div class="flex items-center space-x-4 p-4 mb-4">
            <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </button>
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Add New Prescription</h1>
                <p class="text-sm text-gray-500">Enter prescription information below.</p>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('doctor.prescriptions.store') }}" method="POST" id="prescriptionForm">
                @csrf
                <div class="space-y-4 flex flex-col">
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                        <select name="patient_id" id="patient_id" required
                                class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis</label>
                        <textarea name="diagnosis" id="diagnosis" rows="3" required
                                class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('diagnosis') }}</textarea>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Medications</h3>
                        <div id="medications" class="space-y-4 mt-4">
                            <div class="medication-item border rounded-md p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Medication Name</label>
                                        <input type="text" name="medications[0][medication_name]" required
                                            class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Dosage</label>
                                        <input type="text" name="medications[0][dosage]" required
                                            class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Frequency</label>
                                        <input type="text" name="medications[0][frequency]" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Duration</label>
                                            <input type="number" name="medications[0][duration]" min="1" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Unit</label>
                                            <select name="medications[0][duration_unit]" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <option value="days">Days</option>
                                                <option value="weeks">Weeks</option>
                                                <option value="months">Months</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Special Instructions</label>
                                        <textarea name="medications[0][special_instructions]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" onclick="addMedication()"
                                class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Add Another Medication
                        </button>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            Create Prescription
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let medicationCount = 0;

    function addMedication() {
        medicationCount++;
        const template = document.querySelector('.medication-item').cloneNode(true);
        const inputs = template.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            input.name = input.name.replace('[0]', `[${medicationCount}]`);
            input.value = '';
        });
        
        document.getElementById('medications').appendChild(template);
    }
</script>
@endpush
@endsection