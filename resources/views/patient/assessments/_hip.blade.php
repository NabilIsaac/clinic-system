<div class="">
    <h2 class="mb-6 text-xl font-semibold text-gray-900">Hip Assessment</h2>

    {{-- Posture and Basic Measurements --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Assessment</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Gait</label>
                <textarea name="gait" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Vegetative Changes</label>
                <textarea name="vegetative_changes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Coxa</label>
                <select name="coxa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Type</option>
                    <option value="Vara">Vara</option>
                    <option value="Valga">Valga</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Genu</label>
                <select name="genu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Type</option>
                    <option value="Varus">Varus</option>
                    <option value="Valgus">Valgus</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Leg Measurements --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Leg Measurements</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Right Leg</label>
                <input type="text" name="right_leg" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Left Leg</label>
                <input type="text" name="left_leg" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Right Circumference</label>
                <input type="text" name="right_circumference" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Left Circumference</label>
                <input type="text" name="left_circumference" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Aids</label>
                <input type="text" name="aids" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Footwear</label>
                <input type="text" name="footwear" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
        </div>
    </div>

    <div class="overflow-x-auto border rounded-lg shadow mb-8">
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
                    $joints = ['Hip' => ['Flex', 'Ext', 'Abd', 'Add', 'IR', 'ER'], 'Knee' => ['Flex', 'Ext']];
                @endphp
    
                @foreach ($joints as $joint => $movements)
                    @foreach ($movements as $movement)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-900 border-r">{{ $joint }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900 border-r">{{ $movement }}</td>
                        <td class="px-2 py-2 border-r">
                            <input type="number" name="r_arom[{{ $joint }}][{{ $movement }}]" 
                                class="w-full px-2 py-1 text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </td>
                        <td class="px-2 py-2 border-r">
                            <input type="number" name="r_prom[{{ $joint }}][{{ $movement }}]" 
                                class="w-full px-2 py-1 text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </td>
                        <td class="px-2 py-2 border-r">
                            <input type="text" name="r_end_feel[{{ $joint }}][{{ $movement }}]" 
                                class="w-full px-2 py-1 text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
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
                            <input type="text" name="l_end_feel[{{ $joint }}][{{ $movement }}]" 
                                class="w-full px-2 py-1 text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Muscle Flexibility --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Muscle Flexibility</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach(['Iliopsoas', 'Rectus femoris', 'Obers', 'Hamstrings', 'Adductors', 'Gluteus medius', 'Piriformis', 'Gastrocnemius', 'Soleus'] as $muscle)
                <label class="inline-flex items-center">
                    <input type="checkbox" name="muscle_flexibility[]" value="{{ $muscle }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">{{ $muscle }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Functional Tests --}}
<div class="mb-8">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Functional Tests</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Stairs --}}
        <div class="border rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <label class="text-sm font-medium text-gray-700">Stairs</label>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="functional_test" value="Stairs" class="text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-600">Select</span>
                </div>
            </div>
            <textarea name="stairs_notes" rows="2" 
                class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" 
                placeholder="Add notes about stairs test..."></textarea>
        </div>

        {{-- Squat --}}
        <div class="border rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <label class="text-sm font-medium text-gray-700">Squat</label>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="functional_test" value="Squat" class="text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-600">Select</span>
                </div>
            </div>
            <textarea name="squat_notes" rows="2" 
                class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" 
                placeholder="Add notes about squat test..."></textarea>
        </div>

        {{-- Running --}}
        <div class="border rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <label class="text-sm font-medium text-gray-700">Running</label>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="functional_test" value="Running" class="text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-600">Select</span>
                </div>
            </div>
            <textarea name="running_notes" rows="2" 
                class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" 
                placeholder="Add notes about running test..."></textarea>
        </div>
    </div>
</div>

    {{-- Special Tests --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Special Tests</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach([
                'zero' => 'Zero Test',
                'thirty' => 'Thirty Test',
                'ant_drawer' => 'Anterior Drawer',
                'post_drawer' => 'Posterior Drawer',
                'lachman' => 'Lachman',
                'mcmurray' => 'McMurray',
                'apley_commpression' => 'Apley Compression',
                'traction' => 'Traction',
                'pivot_shift' => 'Pivot Shift',
                'kleiger' => 'Kleiger'
            ] as $key => $test)
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ $test }}</label>
                    <select name="{{ $key }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Select Side</option>
                        <option value="R">Right</option>
                        <option value="L">Left</option>
                    </select>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Additional Tests --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Tests</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">FABER Test</label>
                <input type="text" name="faber" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Trendelenberg Test</label>
                <input type="text" name="trendelenberg" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Reflexes</label>
                <input type="text" name="reflexes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Palpation</label>
                <input type="text" name="palpation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sensation</label>
                <input type="text" name="sensation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Other comments</label>
                <textarea name="other_comments" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>
        </div>
    </div>

    {{-- Treatment and Goals --}}
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Treatment and Goals</h3>
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Treatment Goals</label>
                <textarea name="rx_goals" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Treatment Plan</label>
                <textarea name="rx" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Activities of Daily Living (ADL)</label>
                <textarea name="adl" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>
        </div>
    </div>
</div>