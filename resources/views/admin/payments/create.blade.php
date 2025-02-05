@extends('layouts.app')

@section('title', 'Record Payment')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Record Payment</h1>
            <p class="mt-2 text-sm text-gray-700">Bill #{{ $billing->bill_number }}</p>
        </div>
    </div>

    <div class="mt-8 max-w-2xl">
        <form action="{{ route('admin.payments.store', $billing) }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Payment Details</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Remaining amount: ${{ number_format($billing->remaining_amount, 2) }}
                        </p>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2 space-y-6">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <div class="mt-1">
                                <input type="number" step="0.01" name="amount" id="amount" required min="0.01"
                                    max="{{ $billing->remaining_amount }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    value="{{ old('amount', $billing->remaining_amount) }}">
                            </div>
                            @error('amount')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <select id="payment_method" name="payment_method" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="insurance" {{ old('payment_method') == 'insurance' ? 'selected' : '' }}>Insurance</option>
                            </select>
                            @error('payment_method')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- <div>
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700">Transaction ID</label>
                            <div class="mt-1">
                                <input type="text" name="transaction_id" id="transaction_id"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    value="{{ old('transaction_id') }}">
                            </div>
                            @error('transaction_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div> --}}

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <div class="mt-1">
                                <textarea id="notes" name="notes" rows="3"
                                    class="shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('notes') }}</textarea>
                            </div>
                            @error('notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.billing.show', $billing) }}"
                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Record Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection