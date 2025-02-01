{{-- resources/views/patient/assessments/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center space-x-4 p-4 mb-4">
        <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </button>
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Add New Assessment</h1>
            <p class="text-sm text-gray-500">Enter patient assessment information below.</p>
        </div>
    </div>
    <form action="{{ route('doctor.patient-assessments.store') }}" method="POST" id="assessmentForm">
        @csrf
        <div class="space-y-6 bg-white p-6 rounded-t-lg">

       
        {{-- Basic Health Information --}}
        @include('patient.assessments._basic_health')

        {{-- Disease Type Selection --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Disease Type</label>
            <select name="disease_type" id="diseaseType" class="mt-1 p-2 sm:text-sm w-6/12 block rounded-md border-gray-300">
                <option value="">Select Disease Type</option>
                <option value="spine">Spine</option>
                <option value="stroke">Stroke</option>
                <option value="hip">Hip</option>
                <option value="shoulder">Shoulder</option>
            </select>
        </div>

       {{-- Disease Specific Forms (Initially Hidden) --}}
        <div id="spineForm" class="hidden">
            @includeIf('patient.assessments._spine')
        </div>

        <div id="strokeForm" class="hidden">
            @includeIf('patient.assessments._stroke')
        </div>

        <div id="hipForm" class="hidden">
            @includeIf('patient.assessments._hip')
        </div>

        <div id="shoulderForm" class="hidden">
            @includeIf('patient.assessments._shoulder')
        </div>
    </div>
    <div class="flex justify-end bg-gray-50 rounded-b-lg shadow px-4 py-3 sm:px-6">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Save Assessment
        </button>
    </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('diseaseType').addEventListener('change', function() {
        const value = this.value;
        if (!value) return; // If no value selected, do nothing
        
        // Hide all forms first
        const forms = ['spineForm', 'strokeForm', 'hipForm', 'shoulderForm'];
        forms.forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.classList.add('hidden');
            }
        });
        
        // Show selected form
        const selectedForm = document.getElementById(value + 'Form');
        if (selectedForm) {
            selectedForm.classList.remove('hidden');
        }
    });
</script>
@endpush
@endsection