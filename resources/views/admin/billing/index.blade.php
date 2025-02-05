{{-- @extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Billing</h1>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.billing.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create invoice
                </a>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="#" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Overview
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Invoices
                </a>
            </nav>
        </div>

        <!-- Date Range Selector -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Today
                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="text-sm text-gray-600">2 Aug - 24 Nov</div>
            </div>
            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="mr-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
                Add
            </button>
        </div>

        <!-- Collection Section -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">Collection</h2>
                    <div class="relative">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            All personnels
                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Outstanding Revenue -->
                <div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Outstanding Revenue</h3>
                        <span class="text-xs text-gray-400">Data as of 23 Nov</span>
                    </div>
                    <p class="mt-2 text-3xl font-bold text-gray-900">$0.00</p>
                    <div class="mt-4 h-32">
                        <!-- Chart will go here -->
                        <div class="w-full h-full bg-gradient-to-r from-blue-100 to-blue-50 rounded-lg"></div>
                    </div>
                </div>

                <!-- Recovered Revenue -->
                <div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Recovered Revenue</h3>
                        <span class="text-xs text-gray-400">Data as of 23 Nov</span>
                    </div>
                    <p class="mt-2 text-3xl font-bold text-gray-900">$0.00</p>
                    <div class="mt-4 h-32">
                        <!-- Chart will go here -->
                        <div class="w-full h-full bg-gradient-to-r from-green-100 to-green-50 rounded-lg"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Growth Section -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Growth</h2>
            </div>

            <div class="p-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Monthly Returning Revenue -->
                <div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Monthly Returning Revenue</h3>
                        <span class="text-xs text-gray-400">Data as of 23 Nov</span>
                    </div>
                    <p class="mt-2 text-3xl font-bold text-gray-900">$0.00</p>
                    <div class="mt-4 h-32">
                        <!-- Chart will go here -->
                        <div class="w-full h-full bg-gradient-to-r from-purple-100 to-purple-50 rounded-lg"></div>
                    </div>
                </div>

                <!-- Active Customers -->
                <div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Active Customers</h3>
                        <span class="text-xs text-gray-400">Data as of 23 Nov</span>
                    </div>
                    <p class="mt-2 text-3xl font-bold text-gray-900">0</p>
                    <div class="mt-4 h-32">
                        <!-- Chart will go here -->
                        <div class="w-full h-full bg-gradient-to-r from-yellow-100 to-yellow-50 rounded-lg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Utility Bills</h1>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('admin.billing.create') }}"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                Create New Bill
            </a>
        </div>
    </div>

    <div class="border-b border-gray-200 mt-6">
        <nav class="-mb-px flex space-x-8">
            <button onclick="showTab('overview')" 
                class="tab-button border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                id="overview-tab">
                Overview
            </button>
            <button onclick="showTab('bills')"
                class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                id="bills-tab">
                Bills Table
            </button>
        </nav>
    </div>

    <!-- Overview Tab Content -->
    <div id="overview-content" class="mt-6">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Total Bills Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Bills</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totalBills }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Amount Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending Amount</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($pendingAmount, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paid Amount Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Paid Amount</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($paidAmount, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bills Table Tab Content -->
    <div id="bills-content" class="mt-6 hidden">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bill Number
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Due Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($bills as $bill)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bill->bill_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ucfirst($bill->bill_type) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($bill->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $bill->due_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $bill->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($bill->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.billing.show', $bill) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No bills found.
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

@push('scripts')
<script>
    function showTab(tabName) {
        // Hide all content
        document.getElementById('overview-content').classList.add('hidden');
        document.getElementById('bills-content').classList.add('hidden');
        
        // Show selected content
        document.getElementById(`${tabName}-content`).classList.remove('hidden');
        
        // Update tab styles
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('border-blue-500', 'text-blue-600');
            button.classList.add('border-transparent', 'text-gray-500');
        });
        
        document.getElementById(`${tabName}-tab`).classList.remove('border-transparent', 'text-gray-500');
        document.getElementById(`${tabName}-tab`).classList.add('border-blue-500', 'text-blue-600');
    }
</script>
@endpush
@endsection
