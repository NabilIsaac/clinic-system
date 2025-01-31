@extends('layouts.app')

@section('content')
    <div class="mx-auto">
        <!-- Header -->
        <div class="flex items-center space-x-4 p-4 mb-4">
            <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </button>
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Add New Employee</h1>
                <p class="text-sm text-gray-500">Enter employee information below.</p>
            </div>
        </div>

        <!-- Employee Form -->
         <div class="bg-white p-4">
            <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white shadow rounded-lg">
                @csrf
                <div class="p-6 space-y-6">
                    <!-- Personal Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" name="first_name" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" name="last_name" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" name="phone" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <input type="date" name="birth_date" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gender</label>
                                <select name="gender" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Employment Information</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- <div>
                                <label class="block text-sm font-medium text-gray-700">Employee ID</label>
                                <input type="text" name="employee_id" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div> -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Department</label>
                                <select name="department_id" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select department</option>
                                    @foreach($departments ?? [] as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Roles</label>
                                <div class="mt-2 space-y-2">
                                    @foreach($roles as $role)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label class="ml-2 text-sm text-gray-700">{{ ucfirst($role->name) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Additional Permissions</label>
                                <div class="mt-2 grid grid-cols-2 gap-4">
                                    @foreach($permissions as $permission)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label class="ml-2 text-sm text-gray-700">{{ ucfirst($permission->name) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Join Date</label>
                                <input type="date" name="join_date" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Schedule & Salary</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Working Hours</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="time" name="work_start" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <input type="time" name="work_end" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Salary</label>
                                <input type="number" step="0.01" name="salary" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Bank Account Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Bank Account Information</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Account Name</label>
                                <input type="text" name="account_name" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="As per bank records">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Account Number</label>
                                <input type="text" name="account_number" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Bank account number">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bank Name</label>
                                <input type="text" name="bank_name" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="e.g. HSBC, Citibank">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Branch Name</label>
                                <input type="text" name="bank_branch" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Bank branch location">
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Emergency Contact</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Contact Name</label>
                                <input type="text" name="emergency_contact_name" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Contact Phone</label>
                                <input type="tel" name="emergency_contact_phone" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Relationship</label>
                                <input type="text" name="emergency_contact_relationship" class="mt-1 block w-full h-10 px-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-3 bg-gray-50 flex items-center justify-end space-x-4 rounded-b-lg">
                    <button type="button" onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Employee
                    </button>
                </div>
            </form>
         </div>
       
    </div>
@endsection
