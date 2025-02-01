{{-- resources/views/patient/assessments/hip.blade.php --}}
<div class="space-y-6 p-4">
    <h2 class="text-xl font-semibold">Hip Assessment</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Condition Type --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Condition Type</label>
            <select name="hip[condition_type]" class="mt-1 block w-full rounded-md border-gray-300">
                <option value="fracture">Fracture</option>
                <option value="replacement">Replacement</option>
                <option value="arthritis">Arthritis</option>
            </select>
        </div>

        {{-- Range of Motion --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Range of Motion</label>
            <input type="text" name="hip[rom]" class="mt-1 block w-full rounded-md border-gray-300">
        </div>

        {{-- Weight Bearing Status --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Weight Bearing Status</label>
            <select name="hip[weight_bearing]" class="mt-1 block w-full rounded-md border-gray-300">
                <option value="full">Full Weight Bearing</option>
                <option value="partial">Partial Weight Bearing</option>
                <option value="non">Non Weight Bearing</option>
            </select>
        </div>
    </div>
</div>