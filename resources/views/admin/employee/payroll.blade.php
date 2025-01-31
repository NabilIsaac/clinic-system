@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">{{ __('Payroll & Salary') }}</h2>
            <div class="flex space-x-3">
                <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option>2025</option>
                    <option>2024</option>
                </select>
                <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option>January</option>
                    <option>February</option>
                    <option>March</option>
                </select>
            </div>
        </div>

        <!-- Salary Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-blue-900 mb-1">Base Salary</h3>
                <p class="text-2xl font-bold text-blue-700">$5,000.00</p>
                <p class="text-sm text-blue-600 mt-1">Monthly</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-green-900 mb-1">Bonuses</h3>
                <p class="text-2xl font-bold text-green-700">$750.00</p>
                <p class="text-sm text-green-600 mt-1">This Month</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-purple-900 mb-1">Total Earnings</h3>
                <p class="text-2xl font-bold text-purple-700">$5,750.00</p>
                <p class="text-sm text-purple-600 mt-1">This Month</p>
            </div>
        </div>

        <!-- Detailed Breakdown -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Salary Breakdown</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-b">
                    <div>
                        <p class="font-medium text-gray-900">Base Salary</p>
                        <p class="text-sm text-gray-500">Monthly base compensation</p>
                    </div>
                    <p class="text-gray-900 font-medium">$5,000.00</p>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <div>
                        <p class="font-medium text-gray-900">Performance Bonus</p>
                        <p class="text-sm text-gray-500">Quarterly performance incentive</p>
                    </div>
                    <p class="text-gray-900 font-medium">$500.00</p>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <div>
                        <p class="font-medium text-gray-900">Overtime</p>
                        <p class="text-sm text-gray-500">10 hours @ $50/hour</p>
                    </div>
                    <p class="text-gray-900 font-medium">$250.00</p>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <div>
                        <p class="font-medium text-gray-900">Health Insurance</p>
                        <p class="text-sm text-gray-500">Employee contribution</p>
                    </div>
                    <p class="text-red-600 font-medium">-$200.00</p>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <div>
                        <p class="font-medium text-gray-900">Tax Deductions</p>
                        <p class="text-sm text-gray-500">Federal and state taxes</p>
                    </div>
                    <p class="text-red-600 font-medium">-$1,150.00</p>
                </div>
            </div>

            <!-- Net Pay -->
            <div class="mt-6 pt-6 border-t">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold text-gray-900">Net Pay</p>
                        <p class="text-sm text-gray-500">Final amount after deductions</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">$4,400.00</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
