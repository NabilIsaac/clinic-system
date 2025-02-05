@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Payment Details</h1>
            <p class="mt-2 text-sm text-gray-700">Bill #{{ $payment->bill->bill_number }}</p>
        </div>
    </div>

    <div class="mt-8 max-w-3xl">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Payment Information</h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Amount</dt>
                        <dd class="mt-1 text-sm text-gray-900">${{ number_format($payment->amount, 2) }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($payment->payment_method) }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $payment->created_at->format('M d, Y H:i') }}</dd>
                    </div>
                    @if($payment->transaction_id)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Transaction ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $payment->transaction_id }}</dd>
                    </div>
                    @endif
                    @if($payment->notes)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Notes</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $payment->notes }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.billing.show', $payment->bill) }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                View Bill
            </a>
            @if($payment->status === 'completed')
            <form action="{{ route('admin.payments.void', $payment) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit"
                    onclick="return confirm('Are you sure you want to void this payment?')"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Void Payment
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection