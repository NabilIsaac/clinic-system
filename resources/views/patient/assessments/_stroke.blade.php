<div class="">
    <h2 class="mb-6 text-xl font-semibold text-gray-900">Stroke Assessment</h2>

    {{-- Basic Stroke Information --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date of Onset</label>
                <input type="date" name="date_of_onset_of_stroke" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date of Seeing Practitioner</label>
                <input type="date" name="date_of_seeing_pratitioner" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date of Admission</label>
                <input type="date" name="date_of_admission" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Side of Affectation</label>
                <select name="side_of_affectation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Side</option>
                    <option value="Right Hemi">Right Hemi</option>
                    <option value="Left Hemi">Left Hemi</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">First Course of Treatment</label>
                <select name="first_course_of_treatment" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Treatment</option>
                    <option value="Home care">Home care</option>
                    <option value="Herbal treatment">Herbal treatment</option>
                    <option value="Orthodox treatment">Orthodox treatment</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Risk Factors and Complications --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Risk Factors & Complications</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Risk Factors</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach(['Obesity', 'Hypertension', 'Diabetes', 'Smoking', 'Alcoholic', 'Genetic'] as $factor)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="associated_risk_factors_of_patient[]" value="{{ $factor }}"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">{{ $factor }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="mt-2">
                    <input type="text" name="risk_factors_of_patient" placeholder="Other risk factors..."
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Complications</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(['Aphasia', 'Dysphasia', 'Facial pals', 'Dysarthria'] as $complication)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="associated_complication[]" value="{{ $complication }}"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">{{ $complication }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Patient Condition --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Patient Condition</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Skin Condition</label>
                <select name="skin_condition" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Condition</option>
                    @foreach(['Rashes', 'Unkempt', 'Bedsores'] as $condition)
                        <option value="{{ $condition }}">{{ $condition }}</option>
                    @endforeach
                </select>
                <input type="text" name="skin_condition_other" placeholder="Other skin condition..."
                       class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Mental State</label>
                <select name="mental_state_of_patient" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Mental State</option>
                    @foreach(['depression', 'lethargy', 'irritability', 'aggression', 'cheerful', 'weeping', 'elation/ excited'] as $state)
                        <option value="{{ $state }}">{{ ucfirst($state) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Glasgow Coma Score</label>
                <input type="text" name="glasgow_coma_score" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
        </div>
    </div>

    {{-- Limb Assessment --}}
    @foreach(['upper', 'lower'] as $limbType)
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ ucfirst($limbType) }} Limb Assessment</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <input type="hidden" name="limb_assessments[{{ $limbType }}][limb_type]" value="{{ $limbType }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Muscle Tone</label>
                    <select name="limb_assessments[{{ $limbType }}][muscle_tone]" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Select Tone</option>
                        @foreach(['Spastic', 'Normal', 'Flaccid'] as $tone)
                            <option value="{{ $tone }}">{{ $tone }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Muscle Bulk</label>
                    <select name="limb_assessments[{{ $limbType }}][muscle_bulk]" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Select Bulk</option>
                        @foreach(['Normal', 'Atrophy', 'Hypertrophy'] as $bulk)
                            <option value="{{ $bulk }}">{{ $bulk }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Power</label>
                    <input type="text" name="limb_assessments[{{ $limbType }}][power]" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Deformity</label>
                    <input type="text" name="limb_assessments[{{ $limbType }}][deformity]" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
                @if($limbType === 'upper')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Hand Grip</label>
                        <select name="limb_assessments[{{ $limbType }}][hand_grip]" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Select Grip</option>
                            @foreach(['Normal', 'Impaired', 'Lost'] as $grip)
                                <option value="{{ $grip }}">{{ $grip }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            {{-- Joint Assessment --}}
            <div class="mt-4">
                <h4 class="text-md font-medium text-gray-800 mb-3">Joint Assessment</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $joints = $limbType === 'upper' 
                            ? ['shoulder', 'elbow', 'wrist', 'fingers', 'hand']
                            : ['hip', 'knee', 'ankle', 'foot', 'toes'];
                    @endphp
                    @foreach($joints as $joint)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ ucfirst($joint) }}</label>
                            <select name="joint_assessments[{{ $limbType }}][{{ $joint }}]" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Select Status</option>
                                @foreach(['Contracture', 'Stiff', 'Flexible', 'Active movements'] as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    {{-- Reflexes and Sensory Functions --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Reflexes & Sensory Functions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                'knee_jerk' => ['Hyporeflexia', 'Normal', 'Hyper reflexia'],
                'biceps' => ['Hyporeflexia', 'Normal', 'Hyper reflexia'],
                'spot_test' => ['Normal', 'Impaired', 'Lost'],
                'temperature' => ['Normal', 'Impaired', 'Lost'],
                'touch' => ['Normal', 'Impaired', 'Lost'],
                'colour_distinction' => ['Normal', 'Impaired', 'Lost']
            ] as $reflex => $options)
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ ucwords(str_replace('_', ' ', $reflex)) }}</label>
                    <select name="{{ $reflex }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Select Status</option>
                        @foreach($options as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Communication --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Communication Assessment</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                'language_comprehension' => ['Normal', 'Impaired', 'Lost'],
                'speech' => ['Normal', 'Impaired', 'Lost'],
                'reading_memory' => ['Normal', 'Impaired', 'Lost'],
                'writing_memory' => ['Normal', 'Impaired', 'Lost']
            ] as $type => $options)
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ ucwords(str_replace('_', ' ', $type)) }}</label>
                    <select name="{{ $type }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Select Status</option>
                        @foreach($options as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
            <div>
                <label class="block text-sm font-medium text-gray-700">Impaired Speech Type</label>
                <select name="impaired_speech" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Type</option>
                    @foreach(['Slow', 'Slurred', 'Inauible', 'Incoherent', 'Irritional'] as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Treatment and Goals --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Treatment & Goals</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Treatment Goals</label>
                <textarea name="rx_goals" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                          placeholder="Enter treatment goals..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Treatment (Rx)</label>
                <textarea name="rx" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                          placeholder="Enter treatment details..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Activities of Daily Living (ADL)</label>
                <textarea name="adl" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                          placeholder="Enter ADL details..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Blood Pressure (BPS)</label>
                <textarea name="bps" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                          placeholder="Enter blood pressure details..."></textarea>
            </div>
        </div>
    </div>
</div>