{{-- resources/views/patient/assessments/shoulder.blade.php --}}
<div class="space-y-6 p-4">
    <h2 class="text-xl font-semibold">Shoulder Assessment</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Condition Type --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Condition Type</label>
            <select name="shoulder[condition_type]" class="mt-1 block w-full rounded-md border-gray-300">
                <option value="frozen_shoulder">Frozen Shoulder</option>
                <option value="rotator_cuff">Rotator Cuff Injury</option>
                <option value="impingement">Impingement Syndrome</option>
            </select>
        </div>

        {{-- Movement Assessment --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Movement Assessment</label>
            <div class="space-y-2">
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="shoulder[movements][]" value="flexion">
                        <span class="ml-2">Flexion</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="shoulder[movements][]" value="extension">
                        <span class="ml-2">Extension</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="shoulder[movements][]" value="abduction">
                        <span class="ml-2">Abduction</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Pain Characteristics --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Pain Characteristics</label>
            <textarea name="shoulder[pain_characteristics]" rows="3" class="mt-1 block w-full rounded-md border-gray-300"></textarea>
        </div>
    </div>
</div>