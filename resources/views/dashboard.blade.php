<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @role('patient')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="bg-blue-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Upcoming Appointments') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('View and manage your upcoming appointments') }}</p>
                                <a href="{{ route('appointments.index') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800">{{ __('View Appointments') }} →</a>
                            </div>

                            <div class="bg-green-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Prescriptions') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Access your prescription history') }}</p>
                                <a href="{{ route('prescriptions.index') }}" class="mt-2 inline-block text-green-600 hover:text-green-800">{{ __('View Prescriptions') }} →</a>
                            </div>

                            <div class="bg-purple-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Medical Bills') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Review and pay your medical bills') }}</p>
                                <a href="{{ route('bills.index') }}" class="mt-2 inline-block text-purple-600 hover:text-purple-800">{{ __('View Bills') }} →</a>
                            </div>
                        </div>
                    @endrole

                    @role('doctor')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="bg-blue-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Today\'s Appointments') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('View and manage today\'s appointments') }}</p>
                                <a href="{{ route('appointments.index') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800">{{ __('View Schedule') }} →</a>
                            </div>

                            <div class="bg-green-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Patients') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Access patient records and history') }}</p>
                                <a href="{{ route('patients.index') }}" class="mt-2 inline-block text-green-600 hover:text-green-800">{{ __('View Patients') }} →</a>
                            </div>

                            <div class="bg-purple-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Prescriptions') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Manage patient prescriptions') }}</p>
                                <a href="{{ route('prescriptions.index') }}" class="mt-2 inline-block text-purple-600 hover:text-purple-800">{{ __('View Prescriptions') }} →</a>
                            </div>
                        </div>
                    @endrole

                    @role('super-admin')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="bg-blue-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Users') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Manage system users and roles') }}</p>
                                <a href="{{ route('users.index') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800">{{ __('Manage Users') }} →</a>
                            </div>

                            <div class="bg-green-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Departments') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Manage hospital departments') }}</p>
                                <a href="{{ route('departments.index') }}" class="mt-2 inline-block text-green-600 hover:text-green-800">{{ __('Manage Departments') }} →</a>
                            </div>

                            <div class="bg-purple-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Reports') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('View system analytics and reports') }}</p>
                                <a href="#" class="mt-2 inline-block text-purple-600 hover:text-purple-800">{{ __('View Reports') }} →</a>
                            </div>
                        </div>
                    @endrole
                    @role('admin')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="bg-blue-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Users') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Manage system users and roles') }}</p>
                                <a href="{{ route('users.index') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800">{{ __('Manage Users') }} →</a>
                            </div>

                            <div class="bg-green-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Departments') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('Manage hospital departments') }}</p>
                                <a href="{{ route('departments.index') }}" class="mt-2 inline-block text-green-600 hover:text-green-800">{{ __('Manage Departments') }} →</a>
                            </div>

                            <div class="bg-purple-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Reports') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('View system analytics and reports') }}</p>
                                <a href="#" class="mt-2 inline-block text-purple-600 hover:text-purple-800">{{ __('View Reports') }} →</a>
                            </div>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>