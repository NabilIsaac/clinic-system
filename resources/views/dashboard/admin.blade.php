<div class="p-6 text-gray-900">
    <h2 class="mb-1 text-2xl font-bold">{{ __('Hello, ') }}{{ Auth::user()->name }}! </h2>
    <p class="mb-8 text-sm">{{ __('Welcome back.') }}</p>

    <!-- Key Metrics -->
    <div class="grid grid-cols-2 gap-4 mb-6 md:grid-cols-4">
        <div class="p-4 text-center bg-blue-100 rounded-lg">
            <h3 class="mb-2 text-lg font-semibold">{{ __('Total Users') }}</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
        </div>
        <div class="p-4 text-center bg-green-100 rounded-lg">
            <h3 class="mb-2 text-lg font-semibold">{{ __('Today\'s Appointments') }}</h3>
            <p class="text-3xl font-bold text-green-600">{{ $todayAppointments->count() }}</p>
        </div>
        <div class="p-4 text-center bg-purple-100 rounded-lg">
            <h3 class="mb-2 text-lg font-semibold">{{ __('Active Departments') }}</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $activeDepartments->count() }}</p>
        </div>
        <div class="p-4 text-center bg-yellow-100 rounded-lg">
            <h3 class="mb-2 text-lg font-semibold">{{ __('Pending Requests') }}</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ $pendingRequests->count() }}</p>
        </div>
    </div>

    <!-- Staff Overview -->
    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
        <!-- Department Statistics -->
        <div class="p-4 overflow-y-auto bg-white rounded-lg shadow h-52">
            <h3 class="mb-4 text-lg font-semibold">{{ __('Department Overview') }}</h3>
            <div class="space-y-4">
                @foreach($departmentStats as $dept)
                <div class="pb-2 border-b">
                    <div class="flex items-center justify-between">
                        <span class="font-medium">{{ $dept['name'] }}</span>
                        <span class="text-sm text-gray-600">
                            {{ $dept['doctors'] }} {{ __('Doctors') }} | 
                            {{ $dept['appointments'] }} {{ __('Appointments') }}
                        </span>
                    </div>
                    <div class="h-2 mt-2 bg-gray-200 rounded">
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
        <div class="p-4 bg-white rounded-lg shadow">
            <h3 class="mb-4 text-lg font-semibold">{{ __('Appointment Status') }}</h3>
            <div class="space-y-4">
                @foreach($appointmentStatusStats as $status => $count)
                <div>
                    <div class="flex items-center justify-between">
                        <span class="capitalize">{{ $status }}</span>
                        <span>{{ $count }}</span>
                    </div>
                    <div class="h-2 mt-2 bg-gray-200 rounded">
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
    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
        <div class="p-4 bg-blue-100 rounded-lg">
            <h3 class="mb-2 text-lg font-semibold">{{ __('Users') }}</h3>
            <p class="text-sm text-gray-600">{{ __('Manage system users and roles') }}</p>
            <a href="{{ route('admin.users.index') }}" class="inline-block mt-2 text-blue-600 hover:text-blue-800">{{ __('Manage Users') }} →</a>
        </div>

        <div class="p-4 bg-green-100 rounded-lg">
            <h3 class="mb-2 text-lg font-semibold">{{ __('Departments') }}</h3>
            <p class="text-sm text-gray-600">{{ __('Manage hospital departments') }}</p>
            <a href="#" class="inline-block mt-2 text-green-600 hover:text-green-800">{{ __('Manage Departments') }} →</a>
        </div>

        <div class="p-4 bg-purple-100 rounded-lg">
            <h3 class="mb-2 text-lg font-semibold">{{ __('Reports') }}</h3>
            <p class="text-sm text-gray-600">{{ __('View system analytics and reports') }}</p>
            <a href="#" class="inline-block mt-2 text-purple-600 hover:text-purple-800">{{ __('View Reports') }} →</a>
        </div>
    </div>
    <!-- Recent Activities -->
    <div class="p-4 bg-white rounded-lg shadow">
        <h3 class="mb-4 text-lg font-semibold">{{ __('Recent Activities') }}</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Patient</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Doctor</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Department</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Status</th>
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