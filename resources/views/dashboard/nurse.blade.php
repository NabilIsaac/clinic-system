<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nurse Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Department Today's Schedule -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __("Today's Department Schedule") }}</h3>
                    
                    @if($todayAppointments->isEmpty())
                        <p class="text-gray-600">{{ __('No appointments scheduled for today in your department.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
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
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Dr. {{ $appointment->doctor->user->name }}</div>
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
                                                    <a href="{{ route('vitals.create', ['appointment' => $appointment->id]) }}" class="ml-4 text-green-600 hover:text-green-900">Record Vitals</a>
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

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Quick Actions') }}</h3>
                        <div class="space-y-4">
                            <a href="{{ route('vitals.index') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Record Patient Vitals
                            </a>
                            <a href="{{ route('medications.index') }}" class="block w-full text-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                Administer Medication
                            </a>
                            <a href="{{ route('patients.index') }}" class="block w-full text-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                View Patient List
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Department Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Department Stats') }}</h3>
                        <div class="space-y-4">
                            <div class="border rounded-lg p-4">
                                <p class="text-sm text-gray-600">Total Appointments Today</p>
                                <p class="text-2xl font-bold">{{ $todayAppointments->count() }}</p>
                            </div>
                            <div class="border rounded-lg p-4">
                                <p class="text-sm text-gray-600">Patients Waiting</p>
                                <p class="text-2xl font-bold">{{ $todayAppointments->where('status', 'scheduled')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Recent Activity') }}</h3>
                        <div class="space-y-4">
                            @forelse($todayAppointments->take(5) as $appointment)
                                <div class="border-l-4 border-indigo-400 pl-4">
                                    <p class="text-sm font-medium">{{ $appointment->patient->user->name }}</p>
                                    <p class="text-xs text-gray-600">{{ $appointment->appointment_time->format('H:i') }} - Dr. {{ $appointment->doctor->user->name }}</p>
                                </div>
                            @empty
                                <p class="text-gray-600">No recent activity</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
