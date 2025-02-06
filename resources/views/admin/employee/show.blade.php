@extends('layouts.app')

@section('content')
   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center space-x-4 p-4 mb-4">
                <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Employee Details</h1>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Personal Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Full Name</p>
                                <p class="mt-1">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="mt-1">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Phone Number</p>
                                <p class="mt-1">{{ $user->phone_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Address</p>
                                <p class="mt-1">{{ $user->address }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Gender</p>
                                <p class="mt-1">{{ ucfirst($user->gender) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                                <p class="mt-1">{{ $user->date_of_birth ? date('M d, Y', strtotime($user->date_of_birth)) : 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Employment Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Employee ID</p>
                                <p class="mt-1">{{ $user->employee->employee_id }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Department</p>
                                <p class="mt-1">{{ $user->employee->department->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Joining Date</p>
                                <p class="mt-1">{{ date('M d, Y', strtotime($user->employee->joining_date)) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Salary</p>
                                <p class="mt-1">GHS {{ number_format($user->employee->salary, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Roles and Permissions -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Roles & Permissions</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Roles</p>
                                <div class="mt-1 space-x-2">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Additional Permissions</p>
                                <div class="mt-1 space-x-2">
                                    @foreach($user->permissions as $permission)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Information -->
                    @if($user->employee->account_number)
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Bank Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Account Name</p>
                                <p class="mt-1">{{ $user->employee->account_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Account Number</p>
                                <p class="mt-1">{{ $user->employee->account_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Bank Name</p>
                                <p class="mt-1">{{ $user->employee->bank_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Bank Branch</p>
                                <p class="mt-1">{{ $user->employee->bank_branch }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Emergency Contact -->
                    @if($user->employee->emergency_contact_name)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Emergency Contact</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Contact Name</p>
                                <p class="mt-1">{{ $user->employee->emergency_contact_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Contact Number</p>
                                <p class="mt-1">{{ $user->employee->emergency_contact_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Relationship</p>
                                <p class="mt-1">{{ $user->employee->relationship }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection