
@extends('layouts.app')

@section('title', 'Bills')

@section('content')
<div class="container px-4 mx-auto sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Bills</h1>
            <p class="mt-2 text-sm text-gray-700">A list of all your medical bills and payments.</p>
        </div>
    </div>
    
    <div class="flex flex-col mt-8">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle">
                <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Bill Number</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Due Date</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Amount</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Paid Amount</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bills as $bill)
                            <tr>
                                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                    {{ $bill->bill_number }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $bill->due_date->format('M d, Y') }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    ${{ number_format($bill->total_amount, 2) }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    ${{ number_format($bill->paid_amount, 2) }}
                                </td>
                                <td class="px-3 py-4 text-sm whitespace-nowrap">
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                        {{ $bill->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                           ($bill->status === 'partially_paid' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ str_replace('_', ' ', ucfirst($bill->status)) }}
                                    </span>
                                </td>
                                <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                    <a href="{{ route('patient.bills.show', $bill) }}" class="text-indigo-600 hover:text-indigo-900">
                                        View<span class="sr-only">, {{ $bill->bill_number }}</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-3 py-4 text-sm text-center text-gray-500">
                                    No bills found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        {{ $bills->links() }}
    </div>
</div>
@endsection