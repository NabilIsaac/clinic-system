@extends('layouts.app')

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
@endsection
