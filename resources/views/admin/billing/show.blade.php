@extends('layouts.app')

@section('title', 'View Bill')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Bill Details</h1>
            <p class="mt-2 text-sm text-gray-700">Bill #{{ $billing->bill_number }}</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('admin.billing.edit',  $billing) }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Edit Bill
            </a>
            <a href="{{ route('admin.payments.create', $billing) }}"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Record Payment
            </a>
        </div>
    </div>

    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Bill Information</h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Patient Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $billing->patient_details->name }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                            {{ $billing->status === 'paid' ? 'bg-green-100 text-green-800' : 
                               ($billing->status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ str_replace('_', ' ', ucfirst($billing->status)) }}
                        </span>
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Created Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $billing->created_at->format('M d, Y') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $billing->due_date->format('M d, Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="mt-8 bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Bill Items</h3>
        </div>
        <div class="border-t border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($billing->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $item->name }}
                            @if($item->type)
                            <br>
                            <span class="text-xs text-gray-500">
                                {{ $item->type }}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->unit_price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Total Amount:</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($billing->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Paid Amount:</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($billing->paid_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Remaining Amount:</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($billing->remaining_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @if($billing->payments->isNotEmpty())
    <div class="mt-8 bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Payment History</h3>
        </div>
        <div class="border-t border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($billing->payments as $payment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $payment->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($payment->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ucfirst($payment->payment_method) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.payments.show', $payment) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                            @if($payment->status === 'completed')
                            <form action="{{ route('admin.payments.void', $payment) }}" method="POST" class="inline ml-3">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                    onclick="return confirm('Are you sure you want to void this payment?')">
                                    Void
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($billing->notes)
    <div class="mt-8 bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Notes</h3>
            <p class="mt-1 text-sm text-gray-500">{{ $billing->notes }}</p>
        </div>
    </div>
    @endif
</div>
@endsection

{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg" id="printable-receipt">
            <!-- Header -->
            <div class="px-8 py-6 border-b">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">UTILITY BILL RECEIPT</h1>
                        <p class="text-gray-600">Bill #{{ $bill->bill_number }}</p>
                    </div>
                    <div class="text-right">
                        <img src="{{ asset('logo.png') }}" alt="Company Logo" class="h-12">
                        <p class="text-gray-600">Your Company Name</p>
                        <p class="text-sm text-gray-500">123 Business Street</p>
                        <p class="text-sm text-gray-500">City, State, ZIP</p>
                    </div>
                </div>
            </div>

            <!-- Bill Details -->
            <div class="px-8 py-6 border-b">
                <h2 class="text-lg font-semibold mb-4">Bill Details</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Bill Type</p>
                        <p class="font-medium">{{ ucfirst($bill->bill_type) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="font-medium">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $bill->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($bill->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Billing Period</p>
                        <p class="font-medium">
                            {{ \Carbon\Carbon::parse($bill->period_start)->format('M d, Y') }} - 
                            {{ \Carbon\Carbon::parse($bill->period_end)->format('M d, Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Due Date</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Amount -->
            <div class="px-8 py-6 border-b">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Total Amount</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">${{ number_format($bill->amount, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($bill->notes)
            <div class="px-8 py-6 border-b">
                <h2 class="text-lg font-semibold mb-2">Notes</h2>
                <p class="text-gray-600">{{ $bill->notes }}</p>
            </div>
            @endif

            <!-- Footer -->
            <div class="px-8 py-6 text-sm text-gray-500">
                <p>Thank you for your business</p>
                <p>Generated on {{ now()->format('M d, Y H:i:s') }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end space-x-4">
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print Receipt
            </button>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printable-receipt, #printable-receipt * {
            visibility: visible;
        }
        #printable-receipt {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none;
        }
    }
</style>
@endsection --}}