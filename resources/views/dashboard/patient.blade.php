<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Upcoming Appointments -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Upcoming Appointments') }}</h3>
                    
                    @if($appointments->isEmpty())
                        <p class="text-gray-600">{{ __('No upcoming appointments.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->appointment_time->format('H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Dr. {{ $appointment->doctor->user->name }}</td>
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
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

            <!-- Recent Prescriptions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Recent Prescriptions') }}</h3>
                    
                    @if($prescriptions->isEmpty())
                        <p class="text-gray-600">{{ __('No recent prescriptions.') }}</p>
                    @else
                        <div class="space-y-4">
                            @foreach($prescriptions as $prescription)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium">{{ $prescription->diagnosis->title }}</h4>
                                            <p class="text-sm text-gray-600">Prescribed on {{ $prescription->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <a href="{{ route('prescriptions.show', $prescription) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="text-sm font-medium">Medications:</h5>
                                        <ul class="list-disc list-inside text-sm text-gray-600">
                                            @foreach($prescription->prescriptionDrugs as $drug)
                                                <li>{{ $drug->drug->name }} - {{ $drug->dosage }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Bills -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Recent Bills') }}</h3>
                    
                    @if($bills->isEmpty())
                        <p class="text-gray-600">{{ __('No recent bills.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bill #</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($bills as $bill)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $bill->bill_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $bill->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($bill->total_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($bill->status === 'paid') bg-green-100 text-green-800
                                                    @elseif($bill->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($bill->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route('bills.show', $bill) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                @if($bill->status === 'pending')
                                                    <a href="{{ route('bills.pay', $bill) }}" class="ml-4 text-green-600 hover:text-green-900">Pay Now</a>
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
        </div>
    </div>
</x-app-layout>
