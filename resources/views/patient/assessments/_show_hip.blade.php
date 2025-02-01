{{-- resources/views/patient/assessments/_show_hip.blade.php --}}
<div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
    <dt class="text-sm font-medium text-gray-500">Condition Type</dt>
    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
        {{ ucfirst($patientAssessment->assessment->condition_type) }}
    </dd>
</div>

<div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
    <dt class="text-sm font-medium text-gray-500">Range of Motion</dt>
    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
        {{ $patientAssessment->assessment->rom }}
    </dd>
</div>

<div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
    <dt class="text-sm font-medium text-gray-500">Weight Bearing Status</dt>
    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
        {{ ucfirst($patientAssessment->assessment->weight_bearing) }}
    </dd>
</div>