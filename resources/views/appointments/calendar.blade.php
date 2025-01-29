<x-app-layout>
    <div class="bg-white rounded-lg shadow">
        <!-- Calendar Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Date Selector -->
                    <div class="relative">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <span>{{ now()->format('j M') }}</span>
                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <!-- View Options -->
                    <div class="flex items-center rounded-lg border border-gray-200">
                        <button type="button" class="px-4 py-2 text-sm font-medium {{ request()->get('view') == 'day' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }} hover:text-blue-600">
                            Day
                        </button>
                        <button type="button" class="px-4 py-2 text-sm font-medium {{ request()->get('view') == '3days' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }} hover:text-blue-600 border-l border-r border-gray-200">
                            3 days
                        </button>
                        <button type="button" class="px-4 py-2 text-sm font-medium {{ request()->get('view') == 'week' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }} hover:text-blue-600">
                            Week
                        </button>
                        <button type="button" class="px-4 py-2 text-sm font-medium {{ request()->get('view') == 'month' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }} hover:text-blue-600 border-l border-gray-200">
                            Month
                        </button>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Filter -->
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="mr-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Filter by personnel
                    </button>

                    <!-- Create Event -->
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create event
                    </button>
                </div>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="flex flex-col">
            <div class="flex flex-1">
                <!-- Time Column -->
                <div class="w-20 border-r border-gray-200">
                    <div class="grid grid-cols-1 grid-rows-24 h-full">
                        @for ($hour = 0; $hour < 24; $hour++)
                            <div class="h-20 border-b border-gray-200 -mt-2.5">
                                <span class="text-xs text-gray-500 ml-2">{{ sprintf('%02d:00', $hour) }}</span>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Days Columns -->
                @foreach(['Tue', 'Wed', 'Thu'] as $day)
                <div class="flex-1 border-r border-gray-200">
                    <!-- Day Header -->
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900">{{ $day }}, 24 Apr</h3>
                    </div>

                    <!-- Time Slots -->
                    <div class="relative grid grid-cols-1 grid-rows-24">
                        @for ($hour = 0; $hour < 24; $hour++)
                            <div class="h-20 border-b border-gray-200"></div>
                        @endfor

                        <!-- Example Events -->
                        @if($day === 'Wed')
                            <!-- Meeting Event -->
                            <div class="absolute top-[220px] left-2 right-2 h-16 bg-orange-50 rounded-lg border border-orange-200 p-2">
                                <div class="flex flex-col h-full">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 rounded-full bg-orange-500 mr-2"></div>
                                        <h4 class="text-sm font-medium text-gray-900">Meeting with Mr Aboagye</h4>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">11:00 am - 11:45 am</p>
                                </div>
                            </div>

                            <!-- Video Call Event -->
                            <div class="absolute top-[520px] left-2 right-2 h-24 bg-blue-50 rounded-lg border border-blue-200 p-2">
                                <div class="flex flex-col h-full">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 rounded-full bg-blue-500 mr-2"></div>
                                        <h4 class="text-sm font-medium text-gray-900">Video Call: Julie & Alex</h4>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">01:00 pm - 02:15 pm</p>
                                </div>
                            </div>
                        @endif

                        @if($day === 'Thu')
                            <!-- Performance Update Event -->
                            <div class="absolute top-[180px] left-2 right-2 h-20 bg-green-50 rounded-lg border border-green-200 p-2">
                                <div class="flex flex-col h-full">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                        <h4 class="text-sm font-medium text-gray-900">New onboarding series performance</h4>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">09:00 am - 10:15 am</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
