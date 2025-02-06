
    <div class="space-y-6">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Today's Appointments -->
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Today's Appointments</p>
                        <h3 class="text-2xl font-bold">{{ $todayAppointments ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <!-- Pending Appointments -->
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Pending Appointments</p>
                        <h3 class="text-2xl font-bold">{{ $pendingAppointments ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Patients -->
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Patients</p>
                        <h3 class="text-2xl font-bold">{{ $totalPatients ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <!-- Available Doctors -->
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Available Doctors</p>
                        <h3 class="text-2xl font-bold">{{ $availableDoctors ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('appointments.create') }}" class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">New Appointment</h3>
                <p class="mt-2 text-sm text-gray-600">Schedule a new appointment for a patient</p>
            </a>

            <a href="{{ route('receptionist.patients.create') }}" class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Register Patient</h3>
                <p class="mt-2 text-sm text-gray-600">Add a new patient to the system</p>
            </a>

            <a href="{{ route('receptionist.patients.index') }}" class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Patient Records</h3>
                <p class="mt-2 text-sm text-gray-600">View and manage patient records</p>
            </a>
        </div>

        <!-- Today's Schedule -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Today's Schedule</h3>
            </div>
            <div class="p-4">
                @if(isset($todaySchedule) && $todaySchedule->count() > 0)
                    <div class="space-y-4">
                        @foreach($todaySchedule as $appointment)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                                <div>
                                    <p class="font-semibold">{{ $appointment->start_time->format('g:i A') }}</p>
                                    <p class="text-sm text-gray-600">Patient: {{ $appointment->patient->user->name }}</p>
                                    <p class="text-sm text-gray-600">Doctor: Dr. {{ $appointment->doctor->user->name }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs rounded-full {{ $appointment->status === 'scheduled' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">No appointments scheduled for today</p>
                @endif
            </div>
        </div>
    </div>
