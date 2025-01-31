@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="sm:flex sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Schedule</h1>
            <div class="mt-4 sm:mt-0 flex space-x-3">
                <button type="button" onclick="openScheduleModal()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create schedule
                </button>
            </div>
        </div>

        <!-- Schedule Grid -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Controls -->
            <div class="p-6 border-b border-gray-200">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-4">
                        <!-- Date Navigation -->
                        <div class="relative">
                            <form id="dateFilterForm" class="inline">
                                <input type="hidden" name="view_type" value="{{ $viewType }}">
                                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="hidden" id="startDate">
                                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="hidden" id="endDate">
                                <button type="button" onclick="showDatePicker()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="mr-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $startDate->format('M d') }} - {{ $endDate->format('M d, Y') }}
                                </button>
                            </form>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="navigateWeek(-1)" class="inline-flex items-center p-2 border border-gray-300 rounded-md shadow-sm text-sm text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button type="button" onclick="navigateWeek(1)" class="inline-flex items-center p-2 border border-gray-300 rounded-md shadow-sm text-sm text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- View Options -->
                    <div class="mt-4 sm:mt-0">
                        <div class="flex items-center space-x-2">
                            <a href="?view_type=list{{ request()->has('start_date') ? '&start_date='.request('start_date') : '' }}{{ request()->has('end_date') ? '&end_date='.request('end_date') : '' }}" class="inline-flex items-center px-4 py-2 border {{ $viewType === 'list' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50' }} rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="mr-2 h-5 w-5 {{ $viewType === 'list' ? 'text-blue-500' : 'text-gray-400' }}" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                                </svg>
                                List view
                            </a>
                            <a href="?view_type=grid{{ request()->has('start_date') ? '&start_date='.request('start_date') : '' }}{{ request()->has('end_date') ? '&end_date='.request('end_date') : '' }}" class="inline-flex items-center px-4 py-2 border {{ $viewType === 'grid' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50' }} rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="mr-2 h-5 w-5 {{ $viewType === 'grid' ? 'text-blue-500' : 'text-gray-400' }}" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V11zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                Grid view
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if($viewType === 'grid')
            <!-- Grid View -->
            <div class="overflow-x-auto">
                <div class="min-w-full divide-y divide-gray-200">
                    <!-- Time slots header -->
                    <div class="grid grid-cols-8 bg-gray-50">
                        <div class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Time
                        </div>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <div class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $day }}
                            </div>
                        @endforeach
                    </div>

                    <!-- Time slots grid -->
                    @php
                        $timeSlots = [];
                        $startTime = Carbon\Carbon::createFromTime(8, 0); // Start at 8 AM
                        $endTime = Carbon\Carbon::createFromTime(20, 0);  // End at 8 PM
                        
                        while ($startTime <= $endTime) {
                            $timeSlots[] = $startTime->format('H:i');
                            $startTime->addMinutes(60);
                        }
                    @endphp

                    @foreach($timeSlots as $time)
                        <div class="grid grid-cols-8 divide-x divide-gray-200 hover:bg-gray-50">
                            <!-- Time column -->
                            <div class="px-6 py-2 text-sm text-gray-500 font-medium">
                                {{ $time }}
                            </div>

                            <!-- Schedule slots -->
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <div class="px-6 py-2">
                                    @foreach($staff as $employee)
                                        @if(isset($schedules[$employee->id]))
                                            @foreach($schedules[$employee->id]->where('day_of_week', $day) as $schedule)
                                                @php
                                                    $scheduleStart = Carbon\Carbon::parse($schedule->start_time)->format('H:i');
                                                    $scheduleEnd = Carbon\Carbon::parse($schedule->end_time)->format('H:i');
                                                @endphp
                                                @if($time >= $scheduleStart && $time < $scheduleEnd)
                                                    <div class="flex items-center space-x-2 mb-1 bg-blue-50 p-1 rounded">
                                                        <img class="h-6 w-6 rounded-full" src="{{ $employee->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($employee->name) }}" alt="">
                                                        <div class="text-xs">
                                                            <div class="font-medium text-gray-900">{{ $employee->name }}</div>
                                                            <div class="text-gray-500">{{ $scheduleStart }} - {{ $scheduleEnd }}</div>
                                                        </div>
                                                        <button onclick="editSchedule({{ $schedule->id }})" class="text-xs text-indigo-600 hover:text-indigo-900">Edit</button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <!-- List View -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Staff Member</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($schedules as $schedule)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" src="{{ $schedule->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($schedule->user->name) }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $schedule->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $schedule->user->roles->first()->name ?? 'Staff' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $schedule->day_of_week }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $schedule->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $schedule->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $schedule->notes }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="editSchedule({{ $schedule->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                    <form action="{{ route('admin.staff-schedules.destroy', $schedule) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this schedule?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No schedules found for the selected date range.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!-- Schedule Modal -->
    <div id="scheduleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4" id="modalTitle">Add Schedule</h3>
                <form id="scheduleForm" method="POST" action="{{ route('admin.staff-schedules.store') }}">
                    @csrf
                    <div id="methodField"></div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Staff Member</label>
                        <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @foreach($staff ?? [] as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Day of Week</label>
                        <select name="day_of_week" id="day_of_week" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Start Time</label>
                        <input type="time" name="start_time" id="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">End Time</label>
                        <input type="time" name="end_time" id="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="1" checked>
                                <span class="ml-2">Active</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeScheduleModal()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showDatePicker() {
            document.getElementById('startDate').showPicker();
        }

        function navigateWeek(direction) {
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);
            
            startDate.setDate(startDate.getDate() + (direction * 7));
            endDate.setDate(endDate.getDate() + (direction * 7));
            
            document.getElementById('startDate').value = startDate.toISOString().split('T')[0];
            document.getElementById('endDate').value = endDate.toISOString().split('T')[0];
            
            document.getElementById('dateFilterForm').submit();
        }

        // Auto-submit date filter form when dates change
        document.getElementById('startDate').addEventListener('change', function() {
            document.getElementById('dateFilterForm').submit();
        });
        document.getElementById('endDate').addEventListener('change', function() {
            document.getElementById('dateFilterForm').submit();
        });

        function openScheduleModal() {
            document.getElementById('scheduleModal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = 'Add Schedule';
            document.getElementById('scheduleForm').action = "{{ route('admin.staff-schedules.store') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('scheduleForm').reset();
        }

        function closeScheduleModal() {
            document.getElementById('scheduleModal').classList.add('hidden');
        }

        function editSchedule(id) {
            fetch(`/admin/staff-schedules/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('scheduleModal').classList.remove('hidden');
                    document.getElementById('modalTitle').textContent = 'Edit Schedule';
                    document.getElementById('scheduleForm').action = `/admin/staff-schedules/${id}`;
                    document.getElementById('methodField').innerHTML = '@method("PUT")';
                    
                    // Fill form fields
                    document.getElementById('user_id').value = data.user_id;
                    document.getElementById('day_of_week').value = data.day_of_week;
                    document.getElementById('start_time').value = data.start_time;
                    document.getElementById('end_time').value = data.end_time;
                    document.getElementById('is_active').checked = data.is_active;
                    document.getElementById('notes').value = data.notes || '';
                });
        }

        // Close modal when clicking outside
        document.getElementById('scheduleModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeScheduleModal();
            }
        });
    </script>
    @endpush
@endsection