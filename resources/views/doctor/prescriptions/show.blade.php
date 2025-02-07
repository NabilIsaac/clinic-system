@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Prescription Details</h2>
            <div class="flex space-x-3">
                <a href="{{ route('doctor.prescriptions.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Back to List
                </a>
                @if($prescription->status === 'active')
                    <form action="{{ route('doctor.prescriptions.cancel', $prescription) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700"
                                onclick="return confirm('Are you sure you want to cancel this prescription?')">
                            Cancel Prescription
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Patient Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $prescription->patient->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $prescription->created_at->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $prescription->status === 'active' ? 'bg-green-100 text-green-800' : 
                               ($prescription->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($prescription->status) }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Diagnosis</h3>
            <p class="text-gray-700">{{ $prescription->diagnosis }}</p>
        </div>

        @if($prescription->notes)
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Notes</h3>
                <p class="text-gray-700">{{ $prescription->notes }}</p>
            </div>
        @endif

        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-3">Medications</h3>
            <div class="space-y-4">
                @foreach($prescription->medications as $medication)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Medication Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medication->medication_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Dosage</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medication->dosage }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Frequency</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medication->frequency }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medication->duration }} {{ $medication->duration_unit }}</dd>
                            </div>
                            @if($medication->special_instructions)
                                <div class="col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Special Instructions</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $medication->special_instructions }}</dd>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection