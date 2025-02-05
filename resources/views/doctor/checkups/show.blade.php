@extends('layouts.app')

@section('title', 'View Checkup')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="flex items-center space-x-4 p-4 mb-4">
        <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </button>
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Checkup Details</h1>
            <p class="mt-2 text-sm text-gray-700">Created on {{ $checkup->created_at->format('M d, Y H:i') }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <!-- Patient Information -->
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Patient Information</h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $checkup->patient->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $checkup->patient->email }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Checkup Details -->
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Checkup Details</h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Reason</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $checkup->reason }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Blood Pressure</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $checkup->bp }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Visit History</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $checkup->visit_history }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Additional Comments</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $checkup->additional_comments }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Medications -->
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Medications</h3>
            </div>
            <div class="border-t border-gray-200">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse($checkup->medications as $medication)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $medication->drug->name }}</h4>
                                    <p class="mt-1 text-sm text-gray-500">Dosage: {{ $medication->dosage }}</p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <span class="text-sm text-gray-500">Qty: {{ $medication->quantity }}</span>
                                    <span class="ml-4 text-sm font-medium text-gray-900">${{ number_format($medication->total_price, 2) }}</span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-4 sm:px-6 text-sm text-gray-500">No medications prescribed.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Products -->
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Products</h3>
            </div>
            <div class="border-t border-gray-200">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse($checkup->products as $product)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $product->product->name }}</h4>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <span class="text-sm text-gray-500">Qty: {{ $product->quantity }}</span>
                                    <span class="ml-4 text-sm font-medium text-gray-900">${{ number_format($product->total_price, 2) }}</span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-4 sm:px-6 text-sm text-gray-500">No products added.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Total Amount -->
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Total Amount</h3>
                <span class="text-xl font-bold text-gray-900">${{ number_format($checkup->total_amount, 2) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection