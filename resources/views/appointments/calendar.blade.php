@extends('layouts.app')

@section('content')
<div class="bg-white p-4">
    <!-- Calendar Header -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Date Selector -->
                <div class="relative">
                    <form id="dateForm" action="{{ route('appointments.calendar') }}" method="GET">
                        <input type="hidden" name="view" value="{{ $view }}">
                        <input type="date" name="date" value="{{ $selectedDate->format('Y-m-d') }}" 
                               class="hidden" id="date-picker" onchange="document.getElementById('dateForm').submit()">
                        <button type="button" onclick="document.getElementById('date-picker').showPicker()" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <span>{{ $selectedDate->format('j M Y') }}</span>
                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- View Options -->
                <div class="flex items-center rounded-lg border border-gray-200">
                    <form id="viewForm" action="{{ route('appointments.calendar') }}" method="GET" class="flex">
                        <input type="hidden" name="date" value="{{ $selectedDate->format('Y-m-d') }}">
                        <button type="submit" name="view" value="day" 
                                class="px-4 py-2 text-sm font-medium {{ $view == 'day' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }} hover:text-blue-600">
                            Day
                        </button>
                        <button type="submit" name="view" value="3days" 
                                class="px-4 py-2 text-sm font-medium {{ $view == '3days' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }} hover:text-blue-600 border-l border-r border-gray-200">
                            3 days
                        </button>
                        <button type="submit" name="view" value="week" 
                                class="px-4 py-2 text-sm font-medium {{ $view == 'week' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }} hover:text-blue-600">
                            Week
                        </button>
                        <button type="submit" name="view" value="month" 
                                class="px-4 py-2 text-sm font-medium {{ $view == 'month' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }} hover:text-blue-600 border-l border-gray-200">
                            Month
                        </button>
                    </form>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="flex space-x-2">
                    <a href="{{ route('appointments.calendar', ['view' => $view, 'date' => $selectedDate->copy()->subDays($view === 'month' ? 30 : ($view === 'week' ? 7 : 1))->format('Y-m-d')]) }}" 
                       class="inline-flex items-center px-2 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-500 bg-white hover:bg-gray-50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <a href="{{ route('appointments.calendar', ['view' => $view, 'date' => $selectedDate->copy()->addDays($view === 'month' ? 30 : ($view === 'week' ? 7 : 1))->format('Y-m-d')]) }}" 
                       class="inline-flex items-center px-2 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-500 bg-white hover:bg-gray-50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    New Appointment
                </a>
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="flex flex-col">
        <div class="flex flex-1">
            @if(!$isMonthView)
                <!-- Time Column -->
                <div class="w-20 border-r border-gray-200">
                    <div class="grid grid-cols-1 grid-rows-24 h-full">
                        @for ($hour = 8; $hour < 18; $hour++)
                            <div class="h-20 border-b border-gray-200 -mt-2.5">
                                <span class="text-xs text-gray-500 ml-2">{{ sprintf('%02d:00', $hour) }}</span>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Days Columns -->
                @foreach($days as $day)
                    <div class="flex-1 border-r border-gray-200">
                        <!-- Day Header -->
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900">{{ $day->format('D, M j') }}</h3>
                        </div>

                        <!-- Time Slots -->
                        <div class="relative grid grid-cols-1 grid-rows-24">
                            @for ($hour = 8; $hour < 18; $hour++)
                                <div class="h-20 border-b border-gray-200"></div>
                            @endfor

                            @foreach($appointments as $appointment)
                                @php
                                    $appointmentDate = $appointment->appointment_datetime->format('Y-m-d');
                                    $currentDate = $day->format('Y-m-d');
                                @endphp
                                @if($appointmentDate === $currentDate)
                                    @php
                                        $startTime = $appointment->start_time;
                                        $startHour = (int)$startTime->format('H');
                                        $startMinute = (int)$startTime->format('i');
                                        
                                        $endTime = $appointment->end_time;
                                        $duration = $startTime->diffInMinutes($endTime);
                                        
                                        $topPosition = ($startHour - 8) * 80 + ($startMinute / 60 * 80);
                                        $height = $duration / 60 * 80;
                                        
                                        $statusColors = [
                                            'scheduled' => ['bg-blue-50', 'border-blue-200', 'bg-blue-500'],
                                            'completed' => ['bg-green-50', 'border-green-200', 'bg-green-500'],
                                            'cancelled' => ['bg-red-50', 'border-red-200', 'bg-red-500'],
                                        ];
                                        
                                        $colors = $statusColors[$appointment->status] ?? ['bg-gray-50', 'border-gray-200', 'bg-gray-500'];
                                    @endphp

                                    <a href="{{ route('appointments.show', $appointment) }}" 
                                       class="absolute left-2 right-2 {{ $colors[0] }} rounded-lg border {{ $colors[1] }} p-2 hover:shadow-lg transition-shadow duration-200"
                                       style="top: {{ $topPosition }}px; height: {{ $height }}px;">
                                        <div class="flex flex-col h-full">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 rounded-full {{ $colors[2] }} mr-2"></div>
                                                <h4 class="text-sm font-medium text-gray-900">{{ $appointment->patient->user->name }}</h4>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $startTime->format('h:i A') }} - {{ $endTime->format('h:i A') }}
                                            </p>
                                            <p class="text-xs text-gray-500">Dr. {{ $appointment->doctor->user->name }}</p>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Month View -->
                <div class="w-full">
                    <div class="grid grid-cols-7 gap-px bg-gray-200">
                        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                            <div class="bg-white p-2 text-center text-sm font-medium text-gray-900">
                                {{ $dayName }}
                            </div>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-7 gap-px bg-gray-200">
                        @php
                            $firstDay = $startDate->copy()->startOfMonth();
                            $daysInMonth = $endDate->daysInMonth;
                            $startingDay = $firstDay->dayOfWeek;
                        @endphp

                        @for ($i = 0; $i < $startingDay; $i++)
                            <div class="bg-gray-50 p-2 h-32"></div>
                        @endfor

                        @foreach($days as $day)
                            <div class="bg-white p-2 h-32 overflow-y-auto">
                                <div class="text-sm font-medium text-gray-900 mb-1">{{ $day->format('j') }}</div>
                                @foreach($appointments as $appointment)
                                    @php
                                        $appointmentDate = $appointment->appointment_datetime->format('Y-m-d');
                                        $currentDate = $day->format('Y-m-d');
                                    @endphp
                                    @if($appointmentDate === $currentDate)
                                        @php
                                            $statusColors = [
                                                'scheduled' => ['bg-blue-50', 'border-blue-200', 'bg-blue-500'],
                                                'completed' => ['bg-green-50', 'border-green-200', 'bg-green-500'],
                                                'cancelled' => ['bg-red-50', 'border-red-200', 'bg-red-500'],
                                            ];
                                            $colors = $statusColors[$appointment->status] ?? ['bg-gray-50', 'border-gray-200', 'bg-gray-500'];
                                        @endphp
                                        <a href="{{ route('appointments.show', $appointment) }}" 
                                           class="block mb-1 p-1 {{ $colors[0] }} rounded border {{ $colors[1] }} text-xs hover:shadow-sm">
                                            <div class="flex items-center">
                                                <div class="w-1.5 h-1.5 rounded-full {{ $colors[2] }} mr-1"></div>
                                                <span class="font-medium">{{ $appointment->start_time->format('h:i A') }}</span>
                                            </div>
                                            <div class="ml-2.5">{{ $appointment->patient->user->name }}</div>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach

                        @php
                            $remainingDays = 42 - ($daysInMonth + $startingDay); // 42 is 6 rows * 7 days
                        @endphp
                        @for ($i = 0; $i < $remainingDays; $i++)
                            <div class="bg-gray-50 p-2 h-32"></div>
                        @endfor
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
