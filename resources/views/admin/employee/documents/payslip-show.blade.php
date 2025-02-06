@extends('layouts.app')

@section('content')
    <div class="py-6">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-4 mb-4">
                <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Payslip Details</h1>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">{{ __('Payslip Details') }}</h2>
                    <div class="flex space-x-3">
                        <a href="{{ route('employee.documents.payslips-download', $payslip) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download PDF
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Employee Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Employee Information</h3>
                            <dl class="grid grid-cols-1 gap-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Name:</dt>
                                    <dd class="text-sm text-gray-900">{{ $payslip->employee->name }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Employee ID:</dt>
                                    <dd class="text-sm text-gray-900">{{ $payslip->employee->employee_id }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Department:</dt>
                                    <dd class="text-sm text-gray-900">{{ $payslip->employee->department->name }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Payslip Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Payslip Information</h3>
                            <dl class="grid grid-cols-1 gap-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Payslip Number:</dt>
                                    <dd class="text-sm text-gray-900">{{ $payslip->payslip_number }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Period:</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $payslip->period_start?->format('M d, Y') }} - {{ $payslip->period_end?->format('M d, Y') }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Status:</dt>
                                    <dd class="text-sm">
                                        @switch($payslip->status)
                                            @case('draft')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                                                @break
                                            @case('issued')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Issued</span>
                                                @break
                                            @case('paid')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                                @break
                                        @endswitch
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Earnings -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Earnings</h3>
                            <dl class="grid grid-cols-1 gap-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Basic Salary:</dt>
                                    <dd class="text-sm text-gray-900">{{ Number::currency($payslip->basic_salary, in: 'GHS') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Allowances:</dt>
                                    <dd class="text-sm text-gray-900">{{ Number::currency($payslip->allowances, in: 'GHS') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Overtime:</dt>
                                    <dd class="text-sm text-gray-900">{{ $payslip->overtime_amount ? Number::currency($payslip->overtime_amount, in: 'GHS') : 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Deductions -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Deductions</h3>
                            <dl class="grid grid-cols-1 gap-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Deductions:</dt>
                                    <dd class="text-sm text-gray-900">{{ Number::currency($payslip->deductions, in: 'GHS') }}</dd>
                                </div>
                                <div class="flex justify-between border-t pt-2 mt-2">
                                    <dt class="text-sm font-medium text-gray-900">Net Salary:</dt>
                                    <dd class="text-sm font-bold text-gray-900">{{ Number::currency($payslip->net_salary, in: 'GHS') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection