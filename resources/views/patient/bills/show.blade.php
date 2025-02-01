@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Bill Details</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Bill #{{ $bill->bill_number }}</p>
        </div>
        
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $bill->due_date->format('M d, Y') }}</dd>
                </div>
                
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                            {{ $bill->status === 'paid' ? 'bg-green-100 text-green-800' : 
                               ($bill->status === 'partially_paid' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ str_replace('_', ' ', ucfirst($bill->status)) }}
                        </span>
                    </dd>
                </div>

                <!-- Bill Items -->
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Bill Items</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <div class="mt-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($bill->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->description }}
                                            @if($item->billable)
                                            <span class="text-gray-500">
                                                ({{ class_basename($item->billable_type) }} #{{ $item->billable_id }})
                                            </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ${{ number_format($item->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ${{ number_format($item->total, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Total Amount:</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            ${{ number_format($bill->total_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Paid Amount:</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            ${{ number_format($bill->paid_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Remaining Amount:</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            ${{ number_format($bill->remaining_amount, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </dd>
                </div>
                <div class="mt-4">
                    <a href="{{ route('patient.bills.download', $bill) }}" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download PDF
                    </a>
                </div>

                @if($bill->status !== 'paid')
                <div class="sm:col-span-2">
                    <form action="{{ route('patient.bills.pay', $bill) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Payment Amount</label>
                            <div class="mt-1">
                                <input type="number" step="0.01" max="{{ $bill->remaining_amount }}" name="amount" id="amount" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <select id="payment_method" name="payment_method" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                            </select>
                        </div>

                        <div>
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Make Payment
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection