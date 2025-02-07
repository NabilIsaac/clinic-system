@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Excuse Duty Details</h2>
            <div class="flex space-x-3">
                <a href="{{ route('doctor.excuse-duties.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Back to List
                </a>
                @if($excuseDuty->status === 'issued')
                    <form action="{{ route('doctor.excuse-duties.cancel', $excuseDuty) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to cancel this excuse duty?')"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                            Cancel Excuse Duty
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Patient Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $excuseDuty->patient->name }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $excuseDuty->status === 'issued' ? '