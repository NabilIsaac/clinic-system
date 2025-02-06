@extends('layouts.app')

@section('content')
<div class="mx-auto">
    <!-- Header -->
    <div class="flex items-center space-x-4 mb-8">
        <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </button>
        <h1 class="text-xl font-bold text-gray-900">Book an Appointment</h1>
    </div>

    <div class="bg-white p-4">
        <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm">
            @csrf
            
            <!-- Department Selection -->
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-6">
                    <label for="department_id" class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                    <select name="department_id" id="department_id" required 
                        class="mt-1 block shadow-sm w-full h-10 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Doctor Selection -->
                @role(['nurse','receptionist','admin','super-admin'])
                    <div class="mb-6">
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Doctor</label>
                        <select name="doctor_id" id="doctor_id" required 
                            class="mt-1 block w-full h-10 pl-3 pr-10 py-2 shadow-sm text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Select Doctor</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor['id'] }}" 
                                    data-department="{{ $doctor['department'] }}"
                                    {{ old('doctor_id') == $doctor['id'] ? 'selected' : '' }}>
                                    Dr. {{ $doctor['name'] }} - {{ $doctor['specialization'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> 
                @endrole
                <!-- Patient Selection -->
                @role(['nurse','receptionist','admin','super-admin','doctor'])
                <div class="mb-6">
                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">Patient</label>
                    <select name="patient_id" id="patient_id" required 
                        class="mt-1 block shadow-sm w-full h-10 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Select patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient['id'] }}" 
                                {{ old('patient_id') == $patient['id'] ? 'selected' : '' }}>
                                {{ $patient['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endrole
                <div>
                    <label for="appointment_datetime" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="datetime-local" name="appointment_datetime" id="appointment_datetime" required
                        min="{{ date('Y-m-d') }}"
                        value="{{ old('appointment_datetime') }}"
                        class="mt-1 block w-full h-10 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('appointment_datetime')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                    <input type="time" name="start_time" id="start_time" required
                        value="{{ old('start_time') }}"
                        class="mt-1 block w-full h-10 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('start_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                    <input type="time" name="end_time" id="end_time" required
                        value="{{ old('end_time') }}"
                        class="mt-1 block w-full h-10 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('end_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
           

            <!-- Reason for Visit -->
            <div class="mb-6">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Reason for Visit</label>
                <textarea name="reason" id="reason" rows="3" required
                    class="mt-1 block w-full border-gray-300 p-3 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Please describe your symptoms or reason for the appointment">{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Additional Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                <textarea name="notes" id="notes" rows="2"
                    class="mt-1 block w-full border-gray-300 p-3 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Any additional information you'd like to provide">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Book Appointment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departmentSelect = document.getElementById('department_id');
    const doctorSelect = document.getElementById('doctor_id');
    const doctorOptions = Array.from(doctorSelect.options);

    function filterDoctors() {
        const selectedDepartment = departmentSelect.options[departmentSelect.selectedIndex].text;
        
        // Reset doctor select
        doctorSelect.innerHTML = '<option value="">Select Doctor</option>';
        
        // Filter and add relevant doctors
        doctorOptions.forEach(option => {
            if (option.value === '' || option.dataset.department === selectedDepartment) {
                doctorSelect.add(option.cloneNode(true));
            }
        });
    }

    // Initial filter
    if (departmentSelect.value) {
        filterDoctors();
        // Restore old selection if any
        const oldDoctorId = "{{ old('doctor_id') }}";
        if (oldDoctorId) {
            doctorSelect.value = oldDoctorId;
        }
    }

    // Filter doctors when department changes
    departmentSelect.addEventListener('change', filterDoctors);
});
</script>
@endpush
