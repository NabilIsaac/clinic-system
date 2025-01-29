@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h2 class="text-2xl font-bold mb-4">{{ __('Admin Dashboard') }}</h2>

        <!-- Key Metrics -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold mb-2">{{ __('Total Users') }}</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold mb-2">{{ __('Today\'s Appointments') }}</h3>
                <p class="text-3xl font-bold text-green-600">{{ $todayAppointments }}</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold mb-2">{{ __('Active Departments') }}</h3>
                <p class="text-3xl font-bold text-purple-600">{{ $activeDepartments }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold mb-2">{{ __('Pending Requests') }}</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $pendingRequests }}</p>
            </div>
        </div>

        <!-- Staff Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Department Statistics -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">{{ __('Department Overview') }}</h3>
                <div class="space-y-4">
                    @foreach($departmentStats as $dept)
                    <div class="border-b pb-2">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ $dept['name'] }}</span>
                            <span class="text-sm text-gray-600">
                                {{ $dept['doctors'] }} {{ __('Doctors') }} | 
                                {{ $dept['appointments'] }} {{ __('Appointments') }}
                            </span>
                        </div>
                        <div class="mt-2 h-2 bg-gray-200 rounded">
                            @php
                                $percentage = $totalAppointments > 0 ? ($dept['appointments'] / $totalAppointments) * 100 : 0;
                            @endphp
                            <div class="h-full bg-blue-500 rounded" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Appointment Status Distribution -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">{{ __('Appointment Status') }}</h3>
                <div class="space-y-4">
                    @foreach($appointmentStatusStats as $status => $count)
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="capitalize">{{ $status }}</span>
                            <span>{{ $count }}</span>
                        </div>
                        <div class="mt-2 h-2 bg-gray-200 rounded">
                            @php
                                $totalAppts = array_sum($appointmentStatusStats);
                                $percentage = $totalAppts > 0 ? ($count / $totalAppts) * 100 : 0;
                                $color = match($status) {
                                    'completed' => 'bg-green-500',
                                    'pending' => 'bg-yellow-500',
                                    'cancelled' => 'bg-red-500',
                                    default => 'bg-gray-500'
                                };
                            @endphp
                            <div class="h-full {{ $color }} rounded" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4  mb-6">
            <div class="bg-blue-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">{{ __('Users') }}</h3>
                <p class="text-sm text-gray-600">{{ __('Manage system users and roles') }}</p>
                <a href="{{ route('admin.users.index') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800">{{ __('Manage Users') }} →</a>
            </div>

            <div class="bg-green-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">{{ __('Departments') }}</h3>
                <p class="text-sm text-gray-600">{{ __('Manage hospital departments') }}</p>
                <a href="#" class="mt-2 inline-block text-green-600 hover:text-green-800">{{ __('Manage Departments') }} →</a>
            </div>

            <div class="bg-purple-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">{{ __('Reports') }}</h3>
                <p class="text-sm text-gray-600">{{ __('View system analytics and reports') }}</p>
                <a href="#" class="mt-2 inline-block text-purple-600 hover:text-purple-800">{{ __('View Reports') }} →</a>
            </div>
        </div>
        <!-- Recent Activities -->
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">{{ __('Recent Activities') }}</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentActivities as $activity)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $activity['user'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $activity['doctor'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $activity['department'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $activity['date'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match($activity['status']) {
                                        'Completed' => 'bg-green-100 text-green-800',
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ $activity['status'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        
    </div>
</div>
@endsection