{{-- resources/views/patient/assessments/_show_shoulder.blade.php --}}
<div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
    <dt class="text-sm font-medium text-gray-500">Condition Type</dt>
    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
        {{ str_replace('_', ' ', ucfirst($patientAssessment->assessment->condition_type)) }}
    </dd>
</div>

<div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
    <dt class="text-sm font-medium text-gray-500">Affected Movements</dt>
    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
        <ul class="list-disc pl-5">
            @foreach($patientAssessment->assessment->movements as $movement)
                <li>{{ ucfirst($movement) }}</li>
            @endforeach
        </ul>
    </dd>
</div>

<div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
    <dt class="text-sm font-medium text-gray-500">Pain Characteristics</dt>
    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
        {{ $patientAssessment->assessment->pain_characteristics }}
    </dd>
</div>