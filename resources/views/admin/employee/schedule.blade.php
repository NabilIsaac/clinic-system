@extends('layouts.app')
@php
    function getShiftType($startTime, $endTime) {
        $start = \Carbon\Carbon::parse($startTime);
        $end = \Carbon\Carbon::parse($endTime);
        
        if ($start->format('H:i') >= '06:00' && $start->format('H:i') < '12:00') {
            return 'Morning Shift';
        } elseif ($start->format('H:i') >= '12:00' && $start->format('H:i') < '17:00') {
            return 'Afternoon Shift';
        } else {
            return 'Night Shift';
        }
    }
@endphp
@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">{{ __('Work Schedule') }}</h2>
            <div class="flex space-x-3">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Previous Week
                </button>
                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Next Week
                </button>
            </div>
        </div>

        <!-- Schedule Grid -->
        <div class="grid grid-cols-7 gap-4">
            @foreach ($daysOfWeek as $day)
                @php
                    $schedule = $staffSchedules->first(function($schedule) use ($day) {
                        return $schedule->day_of_week === $day;
                    });
                @endphp
                
                <div class="border rounded-lg p-4">
                    <h3 class="font-medium text-gray-900 mb-2">{{ $day }}</h3>
                    <div class="space-y-2">
                        @if ($schedule)
                            <div class="bg-blue-50 p-2 rounded">
                                <p class="text-sm font-medium text-blue-900">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                </p>
                                <p class="text-xs text-blue-700">
                                    {{ getShiftType($schedule->start_time, $schedule->end_time) }}
                                </p>
                            </div>
                        @else
                            <div class="bg-gray-50 p-2 rounded">
                                <p class="text-sm text-gray-500">Off Day</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach 
        </div>

        <!-- Weekly Summary -->
        <div class="mt-8 bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Weekly Summary</h3>
            @php
                $totalHours = 0;
                $workingDays = $staffSchedules->count();
                $offDays = 7 - $workingDays;
        
                foreach ($staffSchedules as $schedule) {
                    $start = \Carbon\Carbon::parse($schedule->start_time);
                    $end = \Carbon\Carbon::parse($schedule->end_time);
                    $totalHours += $end->diffInHours($start);
                }
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Hours</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalHours }} hours</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Working Days</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $workingDays }} days</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Off Days</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $offDays }} days</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
