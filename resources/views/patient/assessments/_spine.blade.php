<div class="">
    <h2 class="mb-6 text-xl font-semibold text-gray-900">Spine Assessment</h2>

    {{-- Movement Assessment Table --}}
    <div class="overflow-x-auto">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            {{-- Gait & Vegetative Changes --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Gait</label>
                <textarea name="gait"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    rows="2"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Vegetative Changes</label>
                <textarea name="vegetative_changes"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    rows="2"></textarea>
            </div>

            {{-- Posture Evaluations --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Sitting</label>
                <select name="sitting"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Option</option>
                    <option value="Good">Good</option>
                    <option value="Fair">Fair</option>
                    <option value="Poor">Poor</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Standing</label>
                <select name="standing"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Option</option>
                    <option value="Good">Good</option>
                    <option value="Fair">Fair</option>
                    <option value="Poor">Poor</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Lordosis</label>
                <select name="lordosis"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Option</option>
                    <option value="Red">Red</option>
                    <option value="Acc">Acc</option>
                    <option value="Normal">Normal</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Lateral Shift</label>
                <select name="lateral_shift"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Option</option>
                    <option value="Right">Right</option>
                    <option value="Left">Left</option>
                    <option value="Nil">Nil</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kyphosis</label>
                <select name="kyphosis"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Option</option>
                    <option value="Red">Red</option>
                    <option value="Acc">Acc</option>
                    <option value="Normal">Normal</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Correction of Posture</label>
                <select name="correction_of_posture"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Select Option</option>
                    <option value="Better">Better</option>
                    <option value="Worse">Worse</option>
                    <option value="No effect">No effect</option>
                </select>
            </div>

            {{-- Additional Notes --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Asymmetry</label>
                <textarea name="asymmetry"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    rows="2"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">BPS</label>
                <textarea name="bps"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    rows="2"></textarea>
            </div>
        </div>
        <table class="min-w-full mt-5 divide-y divide-gray-200">
            <thead>
                <tr>
                    <th
                        class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                        Movement Type</th>
                    <th
                        class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                        ROM</th>
                    <th
                        class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                        Pain Assessment</th>
                    <th
                        class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                        Test Type</th>
                    <th
                        class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                        Result</th>
                    <th
                        class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                        Comments</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach (['Flex', 'Ext', 'Hyperext', 'Lat_Flex', 'Rot'] as $movement)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ str_replace('_', ' ', $movement) }}
                            </div>
                            @if (in_array($movement, ['Lat_Flex', 'Rot']))
                                <select name="assessments[{{ $movement }}][side]"
                                    class="block w-full mt-2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Select Side</option>
                                    <option value="Left">Left</option>
                                    <option value="Right">Right</option>
                                    <option value="Both">Both</option>
                                </select>
                            @endif
                        </td>

                        <td class="px-4 py-4 whitespace-nowrap">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="assessments[{{ $movement }}][rom]"
                                    class="text-blue-600 border-gray-300 rounded shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Present</span>
                            </label>
                        </td>

                        <td class="px-4 py-4">
                            <div class="space-y-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="assessments[{{ $movement }}][pain]" value="No"
                                        class="text-blue-600 border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600">No Pain</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="assessments[{{ $movement }}][pain]"
                                        value="Yes_Slight"
                                        class="text-yellow-400 border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600">Slight</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="assessments[{{ $movement }}][pain]"
                                        value="Yes_Severe"
                                        class="text-red-600 border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600">Severe</span>
                                </label>
                            </div>
                        </td>

                        <td class="px-4 py-4 whitespace-nowrap">
                            <select name="assessments[{{ $movement }}][test_type]"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Select Test</option>
                                <option value="Lasegue">Lasegue's</option>
                                <option value="Schober">Schober</option>
                                <option value="Patrik">Patrik's</option>
                                <option value="Bowstring">Bowstring</option>
                                <option value="Other">Other</option>
                            </select>
                        </td>

                        <td class="px-4 py-4 whitespace-nowrap">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="assessments[{{ $movement }}][test_result]"
                                    class="text-green-600 border-gray-300 rounded shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Positive</span>
                            </label>
                        </td>

                        <td class="px-4 py-4">
                            <textarea name="assessments[{{ $movement }}][comment]"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                rows="2" placeholder="Add comments..."></textarea>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Additional Assessment Fields --}}
    <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-3">
        <div>
            <label class="block text-sm font-medium text-gray-700">Functional Test</label>
            <textarea name="functional_test" rows="3"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                placeholder="Enter functional test observations..."></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Accessory Movements</label>
            <textarea name="accessory_movements" rows="3"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                placeholder="Enter accessory movements observations..."></textarea>
        </div>
    </div>
    <div>
        {{-- Palpation Types --}}
        <div class="mt-8">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Palpation Types</h3>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                @foreach (['Tender', 'Sore', 'Stiff', 'Thick', 'Elicited spasm', 'Prominent', 'Hypermobile segment'] as $type)
                    <label class="inline-flex items-center">
                        <input type="radio" name="palpation" value="{{ $type }}"
                            class="text-blue-600 border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">{{ $type }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Physical Assessments --}}
        <div class="mt-8">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Physical Assessments</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Abdominal Strength</label>
                    <textarea name="abdominal_strength"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        rows="2" placeholder="Enter abdominal strength assessment..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Wasting</label>
                    <textarea name="wasting"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        rows="2" placeholder="Enter wasting observations..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Manual Traction</label>
                    <textarea name="manual_traction"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        rows="2" placeholder="Enter manual traction assessment..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Other Comments</label>
                    <textarea name="other_comments"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        rows="2" placeholder="Enter any other relevant comments..."></textarea>
                </div>
            </div>
        </div>

        {{-- Treatment and Goals --}}
        <div class="mt-8">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Treatment and Goals</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Treatment Goals (Rx Goals)</label>
                    <textarea name="rx_goals"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        rows="3" placeholder="Enter treatment goals..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Activities of Daily Living (ADL)</label>
                    <textarea name="adl"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        rows="3" placeholder="Enter ADL assessment..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Treatment Plan (Rx)</label>
                    <textarea name="rx"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        rows="3" placeholder="Enter treatment plan..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Review</label>
                    <textarea name="review"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        rows="3" placeholder="Enter review notes..."></textarea>
                </div>
            </div>
        </div>
    </div>

</div>
