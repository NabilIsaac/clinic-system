<div class="p-6 text-gray-900">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-100 p-4 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">{{ __('Today\'s Appointments') }}</h3>
            <p class="text-sm text-gray-600">{{ __('View and manage today\'s appointments') }}</p>
            <a href="{{ route('appointments.index') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800">{{ __('View Schedule') }} →</a>
        </div>

        <div class="bg-green-100 p-4 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">{{ __('Patients') }}</h3>
            <p class="text-sm text-gray-600">{{ __('Access patient records and history') }}</p>
            <a href="{{ route('doctor.patients.index') }}" class="mt-2 inline-block text-green-600 hover:text-green-800">{{ __('View Patients') }} →</a>
        </div>

        <div class="bg-purple-100 p-4 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">{{ __('Prescriptions') }}</h3>
            <p class="text-sm text-gray-600">{{ __('Manage patient prescriptions') }}</p>
            <a href="#" class="mt-2 inline-block text-purple-600 hover:text-purple-800">{{ __('View Prescriptions') }} →</a>
        </div>
    </div>
    <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">{{ __("Today's Schedule") }}</h3>
                <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    {{ __('New Appointment') }}
                </a>
            </div>
            
            @if(isset($todayAppointments) && $todayAppointments->isEmpty())
                <p class="text-gray-600">{{ __('No appointments scheduled for today.') }}</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Time</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Patient</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Reason</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($todayAppointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->appointment_time->format('H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $appointment->patient->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    ID: {{ $appointment->patient->patient_number }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($appointment->reason, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($appointment->status === 'scheduled') bg-green-100 text-green-800
                                            @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <a href="{{ route('appointments.show', $appointment) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        @if($appointment->status === 'scheduled')
                                            <a href="{{ route('diagnoses.create', ['appointment' => $appointment->id]) }}" class="ml-4 text-green-600 hover:text-green-900">Start Consultation</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <!-- Upcoming Appointments -->
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="mb-4 text-lg font-semibold">{{ __('Upcoming Appointments') }}</h3>
                
                @if($upcomingAppointments->isEmpty())
                    <p class="text-gray-600">{{ __('No upcoming appointments.') }}</p>
                @else
                    <div class="space-y-4">
                        @foreach($upcomingAppointments as $appointment)
                            <div class="p-4 border rounded-lg">
                                <div class="flex justify-between">
                                    <div>
                                        <p class="font-medium">{{ $appointment->patient->user->name }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time->format('H:i') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('appointments.show', $appointment) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Patients -->
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="mb-4 text-lg font-semibold">{{ __('Recent Patients') }}</h3>
                
                @if($recentPatients->isEmpty())
                    <p class="text-gray-600">{{ __('No recent patients.') }}</p>
                @else
                    <div class="space-y-4">
                        @foreach($recentPatients as $patient)
                            <div class="p-4 border rounded-lg">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="font-medium">{{ $patient->user->name }}</p>
                                        <p class="text-sm text-gray-600">ID: {{ $patient->patient_number }}</p>
                                    </div>
                                    <a href="{{ route('patients.show', $patient) }}" class="text-indigo-600 hover:text-indigo-900">View History</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>