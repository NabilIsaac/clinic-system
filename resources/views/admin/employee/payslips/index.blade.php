@extends('layouts.app')
@section('content')
<div class="">
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Payslips Management') }}
                </h2>
                <div class="flex items-center space-x-2">
                    <!-- Filter Button -->
                    <a href="{{ route('admin.payslips.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ __('Create Payslip') }}
                    </a>
                    <a href="{{ route('admin.payslips.bulk-create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ __('Bulk Generate') }}
                    </a>
                </div>
            </div>
           
            <!-- Stats -->
            <div class="grid grid-cols-1 gap-6 mt-12 mb-6 md:grid-cols-3">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Total Payslips This Month</div>
                        <div class="text-2xl font-bold">{{ $stats['total_payslips'] }}</div>
                    </div>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Total Amount Paid</div>
                        <div class="text-2xl font-bold">${{ number_format($stats['total_paid'], 2) }}</div>
                    </div>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Pending Approvals</div>
                        <div class="text-2xl font-bold">{{ $stats['pending_approvals'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.payslips.index') }}" method="GET" class="flex items-center justify-between w-full">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Period</label>
                            <input type="month" name="period" value="{{ request('period') }}" class="block w-full mt-1 border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="block w-full mt-1 text-sm border-gray-300 rounded-md">
                                <option value="">All Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Issued</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Department</label>
                            <select name="department" class="block w-full mt-1 text-sm border-gray-300 rounded-md">
                                <option value="">All Departments</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-50">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Payslips Table -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Employee</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Period</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Basic Salary</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Total Bonuses</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Net Salary</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($payslips as $payslip)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $payslip->employee->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $payslip->employee->department->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $payslip->period_start?->format('M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        ${{ number_format($payslip->basic_salary, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        ${{ number_format($payslip->total_bonuses, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        ${{ number_format($payslip->net_salary, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $payslip->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                               ($payslip->status === 'issued' ? 'bg-blue-100 text-blue-800' : 
                                               'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($payslip->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <div class="flex space-x-3">
                                            <a href="{{ route('admin.payslips.show', $payslip) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('admin.payslips.download', $payslip) }}" class="text-green-600 hover:text-green-900">Download</a>
                                            @if($payslip->status === 'draft')
                                                <form action="{{ route('admin.payslips.issue', $payslip) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-blue-600 hover:text-blue-900">Issue</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                        No payslips found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <x-pagination :items="$payslips" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection