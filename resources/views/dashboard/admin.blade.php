<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Total Patients -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Patients</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalPatients }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Appointments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Today's Appointments</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalAppointments }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Bills -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Pending Bills</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $pendingBills }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-600 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('users.create') }}" class="block text-sm text-indigo-600 hover:text-indigo-900">➕ Add New User</a>
                            <a href="{{ route('departments.create') }}" class="block text-sm text-indigo-600 hover:text-indigo-900">➕ Add Department</a>
                            <a href="{{ route('reports.index') }}" class="block text-sm text-indigo-600 hover:text-indigo-900">📊 View Reports</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Recent Appointments') }}</h3>
                    
                    @if($recentAppointments->isEmpty())
                        <p class="text-gray-600">{{ __('No recent appointments.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentAppointments as $appointment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                                <div class="text-sm text-gray-500">{{ $appointment->appointment_time->format('H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $appointment->patient->user->name }}</div>
                                                <div class="text-sm text-gray-500">ID: {{ $appointment->patient->patient_number }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Dr. {{ $appointment->doctor->user->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->department->name }}</td>
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
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- System Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Activity -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">{{ __('System Overview') }}</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Total Departments</span>
                                <span class="text-sm font-medium">{{ \App\Models\Department::count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Active Doctors</span>
                                <span class="text-sm font-medium">{{ \App\Models\Employee::role('doctor')->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Active Nurses</span>
                                <span class="text-sm font-medium">{{ \App\Models\Employee::role('nurse')->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Total Staff</span>
                                <span class="text-sm font-medium">{{ \App\Models\Employee::role('staff')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Quick Reports') }}</h3>
                        <div class="space-y-4">
                            <a href="{{ route('reports.appointments') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                <h4 class="font-medium">Appointment Analytics</h4>
                                <p class="text-sm text-gray-600">View detailed appointment statistics</p>
                            </a>
                            <a href="{{ route('reports.revenue') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                <h4 class="font-medium">Revenue Report</h4>
                                <p class="text-sm text-gray-600">Financial overview and analytics</p>
                            </a>
                            <a href="{{ route('reports.departments') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                <h4 class="font-medium">Department Performance</h4>
                                <p class="text-sm text-gray-600">Department-wise statistics</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
