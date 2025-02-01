{{-- resources/views/patient/assessments/shoulder.blade.php --}}
<div class="space-y-6 p-4">
    <h2 class="text-xl font-semibold">Shoulder Assessment</h2>

   {{-- General Section --}}
<div class="space-y-8">
    {{-- Observation and Limitations --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Observation</label>
            <textarea name="observation" rows="3" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Limitations</label>
            <textarea name="limitations" rows="3" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
        </div>
    </div>

    {{-- Affected Side --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Can lie on affected side?</label>
        <div class="flex space-x-4">
            <label class="inline-flex items-center">
                <input type="radio" name="is_lie_affected_side" value="Yes" class="text-blue-600 focus:ring-blue-500">
                <span class="ml-2">Yes</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="is_lie_affected_side" value="No" class="text-blue-600 focus:ring-blue-500">
                <span class="ml-2">No</span>
            </label>
        </div>
    </div>

    {{-- Joint Movement Assessment Table --}}
    <div class="overflow-x-auto border rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th rowspan="2" class="px-4 py-3 text-sm font-medium text-gray-900 border-r">Joint</th>
                    <th rowspan="2" class="px-4 py-3 text-sm font-medium text-gray-900 border-r">Movement</th>
                    <th colspan="3" class="px-4 py-3 text-sm font-medium text-gray-900 border-r">Right (R)</th>
                    <th colspan="3" class="px-4 py-3 text-sm font-medium text-gray-900">Left (L)</th>
                </tr>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-sm font-medium text-gray-900 border-r">AROM</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-900 border-r">PROM</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-900 border-r">End Feel</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-900 border-r">AROM</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-900 border-r">PROM</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-900">End Feel</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php
                    $movements = [
                        'shoulder' => ['flexion', 'extension', 'abduction', 'adduction', 'internal_rotation', 'external_rotation'],
                        'elbow' => ['flexion', 'extension', 'pronation', 'supination'],
                        'wrist' => ['flexion', 'extension', 'ulnar_deviation', 'radial_deviation']
                    ];
                @endphp

                @foreach ($movements as $joint => $jointMovements)
                    @foreach ($jointMovements as $movement)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-900 border-r">{{ ucfirst($joint) }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900 border-r">{{ ucfirst(str_replace('_', ' ', $movement)) }}</td>
                        <td class="px-2 py-2 border-r">
                            <input type="number" name="r_arom[{{ $joint }}][{{ $movement }}]" 
                                class="w-full px-2 py-1 text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </td>
                        <td class="px-2 py-2 border-r">
                            <input type="number" name="r_prom[{{ $joint }}][{{ $movement }}]" 
                                class="w-full px-2 py-1 text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </td>
                        <td class="px-2 py-2 border-r">
                            <select name="r_end_feel[{{ $joint }}][{{ $movement }}]" 
                                class="w-full px-2 py-1 text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select</option>
                                @foreach (['normal', 'firm', 'soft', 'empty', 'spasm'] as $feel)
                                    <option value="{{ $feel }}">{{ ucfirst($feel) }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-2 py-2 border-r">
                            <input type="number" name="l_arom[{{ $joint }}][{{ $movement }}]" 
                                class="w-full px-2 py-1 text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </td>
                        <td class="px-2 py-2 border-r">
                            <input type="number" name="l_prom[{{ $joint }}][{{ $movement }}]" 
                                class="w-full px-2 py-1 text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </td>
                        <td class="px-2 py-2">
                            <select name="l_end_feel[{{ $joint }}][{{ $movement }}]" 
                                class="w-full px-2 py-1 text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select</option>
                                @foreach (['normal', 'firm', 'soft', 'empty', 'spasm'] as $feel)
                                    <option value="{{ $feel }}">{{ ucfirst($feel) }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Special Tests --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach (['speed', 'ligamentus', 'foment', 'allen'] as $test)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ ucfirst($test) }}</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="{{ $test }}" value="R" class="text-blue-600 focus:ring-blue-500">
                        <span class="ml-2">Right</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="{{ $test }}" value="L" class="text-blue-600 focus:ring-blue-500">
                        <span class="ml-2">Left</span>
                    </label>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Additional Tests --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ([
            'accessory_movements', 'finger_movements', 'muscle_power', 'horizontal_abduction',
            'impingement_test', 'supraspinatus', 'distraction', 'reflexes', 'palpation',
            'sensation', 'sulcus', 'ok', 'tinel'
        ] as $field)
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                <textarea name="{{ $field }}" rows="2" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>
        @endforeach
    </div>

    {{-- Treatment Section --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Treatment Goals</label>
            <textarea name="rx_goals" rows="3" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Treatment Plan</label>
            <textarea name="rx" rows="3" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">ADL</label>
            <textarea name="adl" rows="3" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
        </div>
    </div>

    {{-- Other Comments --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Other Comments</label>
        <textarea name="other_comments" rows="3" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
    </div>
</div>
</div>