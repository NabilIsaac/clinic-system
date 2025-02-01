{{-- resources/views/patient/assessments/_basic_health.blade.php --}}
<div class="">
    <h2 class="text-xl font-semibold">Basic Health Information</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-4 mt-5 gap-6">
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Select Patient</label>
            <select name="patient_id" class="mt-1 sm:text-sm p-2 shadow-sm rounded-md block w-full">
                <option value="">Select a patient</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">HPT/DM</label>
            <select name="hpt_dm" class="mt-1 sm:text-sm h-10 p-2 shadow-sm rounded-md block w-full">
                <option value="">Select Option</option>
                <option value="HPT">HPT</option>
                <option value="DM">DM</option>
                <option value="Internal fixation">Internal fixation</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Present Complaint (PC)</label>
            <textarea name="pc" class="mt-1 block p-2 shadow-sm rounded-md w-full"></textarea>
        </div>

        {{-- Add other basic health fields --}}
    </div>

    {{-- Pain Assessment Section --}}
    <div class="mt-6">
        <h3 class="text-lg font-medium">Pain Assessment</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            {{-- Pain Nature --}}
            <div>
                <label for="pain_nature" class="block text-sm font-medium text-gray-700">Nature of Pain</label>
                <div class="mt-1">
                    <input type="text" name="pain_nature" id="pain_nature" 
                        class="shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="Describe the nature of pain">
                </div>
            </div>
        
            {{-- Degree of Pain --}}
            <div>
                <label for="degree_of_pain" class="block text-sm font-medium text-gray-700">Degree of Pain</label>
                <div class="mt-1">
                    <input type="text" name="degree_of_pain" id="degree_of_pain" 
                        class="shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="Specify degree of pain">
                </div>
            </div>
        
            {{-- Pain Scale --}}
            <div>
                <label for="pain_scale" class="block text-sm font-medium text-gray-700">Pain Scale (0-10)</label>
                <div class="mt-1">
                    <input type="number" name="pain_scale" id="pain_scale" min="0" max="10" 
                        class="shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="Rate pain from 0 to 10">
                </div>
                <p class="mt-1 text-xs text-gray-500">0 = No Pain, 10 = Worst Possible Pain</p>
            </div>
        
            {{-- Pain Frequency --}}
            <div>
                <label for="pain_frequency" class="block text-sm font-medium text-gray-700">Pain Frequency</label>
                <div class="mt-1">
                    <select name="pain_frequency" id="pain_frequency" 
                        class="shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <option value="">Select frequency</option>
                        <option value="Constant">Constant</option>
                        <option value="Periodic">Periodic</option>
                        <option value="Occasional">Occasional</option>
                    </select>
                </div>
            </div>
        
            {{-- Aggravated By --}}
            <div>
                <label for="aggravated_by" class="block text-sm font-medium text-gray-700">Aggravated By</label>
                <div class="mt-1">
                    <input type="text" name="aggravated_by" id="aggravated_by" 
                        class="shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="What makes the pain worse?">
                </div>
            </div>
        
            {{-- Eased By --}}
            <div>
                <label for="eased_by" class="block text-sm font-medium text-gray-700">Eased By</label>
                <div class="mt-1">
                    <input type="text" name="eased_by" id="eased_by" 
                        class="shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="What makes the pain better?">
                </div>
            </div>
        
            {{-- Pain Period --}}
            <div>
                <label for="pain_period" class="block text-sm font-medium text-gray-700">Pain Period</label>
                <div class="mt-1">
                    <select name="pain_period" id="pain_period" 
                        class="shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <option value="">Select period</option>
                        <option value="Evening">Evening</option>
                        <option value="Rising">Rising</option>
                        <option value="Day pain">Day pain</option>
                    </select>
                </div>
            </div>
        
            {{-- Associated Symptoms --}}
            <div>
                <label for="associated_symptoms" class="block text-sm font-medium text-gray-700">Associated Symptoms</label>
                <div class="mt-1">
                    <select name="associated_symptoms" id="associated_symptoms" 
                        class="shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <option value="">Select symptoms</option>
                        <option value="Dizziness">Dizziness</option>
                        <option value="Micturition">Micturition</option>
                        <option value="Breathing">Breathing</option>
                        <option value="Coughing/Sneezing">Coughing/Sneezing</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>