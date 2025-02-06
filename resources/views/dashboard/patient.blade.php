@extends('layouts.app')

@section('content')
<div class="mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Patient Dashboard') }}</h2>

    <!-- Analytics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Upcoming Appointments</p>
                    <h3 class="text-2xl font-bold">{{ $upcomingAppointments->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Active Prescriptions</p>
                    <h3 class="text-2xl font-bold">{{ $activePrescriptions ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 mr-4">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Medical Records</p>
                    <h3 class="text-2xl font-bold">{{ $totalRecords ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Next Appointment Card -->
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Next Appointment</p>
                    @if($nextAppointment)
                        <h3 class="text-sm font-bold">
                            {{ $nextAppointment->appointment_datetime->format('M d, Y g:i A') }}
                            <br>
                            <span class="text-gray-600">with Dr. {{ $nextAppointment->doctor->user->name }}</span>
                            <span class="text-gray-600">in {{ $nextAppointment->department->name }}</span>
                        </h3>
                    @else
                        <h3 class="text-sm text-gray-600">No upcoming appointments</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
            <h3 class="text-lg font-semibold mb-2">{{ __('Appointments') }}</h3>
            <p class="text-sm text-gray-600 mb-4">{{ __('View and manage your appointments') }}</p>
            <div class="flex space-x-2">
                <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-3 py-2 border border-blue-300 text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">
                    {{ __('View All') }}
                </a>
                <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-3 py-2 border border-blue-300 text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">
                    {{ __('Book New') }}
                </a>
            </div>
        </div>

        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
            <h3 class="text-lg font-semibold mb-2">{{ __('Prescriptions') }}</h3>
            <p class="text-sm text-gray-600 mb-4">{{ __('Access your prescriptions') }}</p>
            <div class="flex space-x-2">
                <a href="{{ route('patient.prescriptions.index') }}" class="inline-flex items-center px-3 py-2 border border-green-300 text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200">
                    {{ __('View All') }}
                </a>
                <a href="#" class="inline-flex items-center px-3 py-2 border border-green-300 text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200">
                    {{ __('Request Refill') }}
                </a>
            </div>
        </div>

        <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
            <h3 class="text-lg font-semibold mb-2">{{ __('Medical Records') }}</h3>
            <p class="text-sm text-gray-600 mb-4">{{ __('View your medical history') }}</p>
            <div class="flex space-x-2">
                <a href="#" class="inline-flex items-center px-3 py-2 border border-purple-300 text-sm font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200">
                    {{ __('View All') }}
                </a>
                <a href="#" class="inline-flex items-center px-3 py-2 border border-purple-300 text-sm font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200">
                    {{ __('Download') }}
                </a>
            </div>
        </div>

        <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
            <h3 class="text-lg font-semibold mb-2">{{ __('Bills') }}</h3>
            <p class="text-sm text-gray-600 mb-4">{{ __('View your Bills') }}</p>
            <div class="flex space-x-2">
                <a href="{{route('patient.bills.index')}}" class="inline-flex items-center px-3 py-2 border border-purple-300 text-sm font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200">
                    {{ __('View All') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Appointments Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Upcoming Appointments -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Upcoming Appointments</h3>
            </div>
            <div class="p-4">
                @if($upcomingAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingAppointments as $appointment)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                                <div>
                                    <p class="font-semibold">{{ $appointment->appointment_datetime->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $appointment->start_time->format('g:i A') }} - {{ $appointment->end_time->format('g:i A') }}
                                    </p>
                                    <p class="text-sm text-gray-600">Dr. {{ $appointment->doctor->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $appointment->department->name }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <span class="px-3 py-1 text-xs rounded-full 
                                        {{ $appointment->status === 'scheduled' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">No upcoming appointments</p>
                @endif
            </div>
        </div>

        <!-- Recent Appointments -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Recent Appointments</h3>
            </div>
            <div class="p-4">
                @if($recentAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentAppointments as $appointment)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                                <div>
                                    <p class="font-semibold">{{ $appointment->appointment_datetime->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600">Dr. {{ $appointment->doctor->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $appointment->department->name }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">View Details</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">No recent appointments</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentActivities ?? [] as $activity)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activity->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $activity->status === 'Completed' ? 'bg-green-100 text-green-800' : 
                                   ($activity->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $activity->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No recent activity</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection