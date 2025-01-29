<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Today's Schedule -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">{{ __("Today's Schedule") }}</h3>
                        <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('New Appointment') }}
                        </a>
                    </div>
                    
                    @if($todayAppointments->isEmpty())
                        <p class="text-gray-600">{{ __('No appointments scheduled for today.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Upcoming Appointments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Upcoming Appointments') }}</h3>
                        
                        @if($upcomingAppointments->isEmpty())
                            <p class="text-gray-600">{{ __('No upcoming appointments.') }}</p>
                        @else
                            <div class="space-y-4">
                                @foreach($upcomingAppointments as $appointment)
                                    <div class="border rounded-lg p-4">
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Recent Patients') }}</h3>
                        
                        @if($recentPatients->isEmpty())
                            <p class="text-gray-600">{{ __('No recent patients.') }}</p>
                        @else
                            <div class="space-y-4">
                                @foreach($recentPatients as $patient)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between items-start">
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
    </div>
</x-app-layout>
