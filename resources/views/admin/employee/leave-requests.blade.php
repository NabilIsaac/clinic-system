@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg" x-data="{ 
    showModal: false,
    leaveType: '',
    startDate: '',
    endDate: '',
    calculateDays() {
        if (this.startDate && this.endDate) {
            const start = new Date(this.startDate);
            const end = new Date(this.endDate);
            const diffTime = Math.abs(end - start);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        }
        return 0;
    }
}">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">{{ __('Leave Requests') }}</h2>
            <button @click="showModal = true" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Request Leave
            </button>
        </div>

        <!-- Leave Balance -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach($leaveBalances as $type => $balance)
            <div class="bg-{{ $balance['color'] }}-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-{{ $balance['color'] }}-900 mb-1">{{ $balance['name'] }}</h3>
                <p class="text-2xl font-bold text-{{ $balance['color'] }}-700">
                    {{ $balance['total'] }} days
                </p>
                <p class="text-sm text-{{ $balance['color'] }}-600 mt-1">
                    {{ $balance['remaining'] }} remaining
                </p>
            </div>
            @endforeach
        </div>

        <!-- Leave Request Modal -->
        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true"
             style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true"></div>

                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                     @click.away="showModal = false">
                    <form action="{{ route('employee.leave-requests.store') }}" method="POST" 
                          x-on:submit="$event.preventDefault(); validateForm($event)">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Request Leave</h3>
                            
                            <div class="mb-4">
                                <label for="leave_type" class="block text-sm font-medium text-gray-700">Leave Type</label>
                                <select id="leave_type" name="leave_type" x-model="leaveType" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Select Leave Type</option>
                                    @foreach($leaveTypes as $type => $details)
                                        <option value="{{ $type }}">{{ $details['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                    <input type="date" id="start_date" name="start_date" x-model="startDate" required
                                           min="{{ date('Y-m-d') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                    <input type="date" id="end_date" name="end_date" x-model="endDate" required
                                           min="{{ date('Y-m-d') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>

                            <div x-show="startDate && endDate" class="text-sm text-gray-600 mb-4">
                                Requested days: <span x-text="calculateDays()"></span>
                            </div>

                            <div>
                                <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                                <textarea id="reason" name="reason" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        rows="3"></textarea>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Submit Request
                            </button>
                            <button type="button" @click="showModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Leave Requests Table -->
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Leave History</h3>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($leaveRequests as $request)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $request->type }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $request->start_date ? date('M d, Y', strtotime($request->start_date)) : "No date" }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $request->end_date ? date('M d, Y', strtotime($request->end_date)) : "No date" }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $request->reason }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">
                                                @php
                                                    $start = \Carbon\Carbon::parse($request->start_date);
                                                    $end = \Carbon\Carbon::parse($request->end_date);
                                                    $duration = $start->diffInDays($end) + 1;
                                                @endphp
                                                {{ $duration }} {{ Str::plural('day', $duration) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($request->status === 'approved') bg-green-100 text-green-800
                                                @elseif($request->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            No leave requests found
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function validateForm(event) {
    const form = event.target;
    const leaveType = form.leave_type.value;
    const startDate = new Date(form.start_date.value);
    const endDate = new Date(form.end_date.value);
    
    if (startDate > endDate) {
        alert('End date cannot be before start date');
        return false;
    }

    const diffTime = Math.abs(endDate - startDate);
    const requestedDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

    const remainingDays = {
        annual: {{ $leaveBalances['annual']['remaining'] }},
        sick: {{ $leaveBalances['sick']['remaining'] }},
        personal: {{ $leaveBalances['personal']['remaining'] }}
    };

    if (leaveType !== 'unpaid' && requestedDays > remainingDays[leaveType]) {
        alert(`You don't have enough ${leaveType} leave days remaining. You have ${remainingDays[leaveType]} days left.`);
        return false;
    }

    form.submit();
}
</script>
@endsection