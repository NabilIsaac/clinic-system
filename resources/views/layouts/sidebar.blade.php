<div class="w-64 inset-y-0 left-0 bg-white border-r h-screen">
    <div class="fixed w-64">
        <div x-data="{ showUserModal: false, currentView: 'work' }" class="flex flex-col h-full">
            <!-- User Profile Button -->
            <div class="p-4 border-b">
                <button type="button" @click="showUserModal = !showUserModal" 
                        class="flex items-center w-full hover:bg-gray-50 p-2 rounded-lg">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                        <span class="text-orange-600 font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-3 text-left">
                        <span class="text-sm font-medium text-gray-900 block">{{ Auth::user()->name }}</span>
                        <span class="text-xs text-gray-500" x-text="currentView === 'work' ? 'Work Account' : 'Employee Profile'"></span>
                    </div>
                    <svg class="w-5 h-5 ml-auto text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                </button>

                <!-- User Modal -->
                <div x-show="showUserModal" 
                     @click.away="showUserModal = false"
                     class="absolute right-0 w-64 mt-2 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                    
                    <!-- Account Switch -->
                    <div class="p-3">
                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Account Type</h4>
                        <div class="space-y-2">
                            <button @click="currentView = 'work'; showUserModal = false" 
                                    class="flex items-center w-full space-x-2 p-2 rounded-md"
                                    :class="{ 'bg-gray-50': currentView === 'work' }">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Work Account</span>
                                <svg x-show="currentView === 'work'" class="w-4 h-4 ml-auto text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <button @click="currentView = 'employee'; showUserModal = false" 
                                    class="flex items-center w-full space-x-2 p-2 rounded-md"
                                    :class="{ 'bg-gray-50': currentView === 'employee' }">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Employee Profile</span>
                                <svg x-show="currentView === 'employee'" class="w-4 h-4 ml-auto text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <!-- User Actions -->
                    <div class="p-2">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">
                            {{ __('Profile Settings') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto">
                <!-- Work Account Navigation -->
                <nav x-show="currentView === 'work'" class="p-4 space-y-1">
                    @role('admin|super-admin')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-50' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            {{ __('Dashboard') }}
                        </a>

                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 {{ request()->routeIs('admin.users.*') ? 'bg-gray-50' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            {{ __('Users') }}
                        </a>

                        <a href="#" 
                           class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            {{ __('Departments') }}
                        </a>
                    @endrole

                    @role('doctor')
                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ __('Appointments') }}
                        </a>
                    @endrole
                </nav>

                <!-- Employee Profile Navigation -->
                <nav x-show="currentView === 'employee'" class="p-4 space-y-1">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                        {{ __('Employee Portal') }}
                    </h3>

                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        {{ __('Payroll & Salary') }}
                    </a>

                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ __('Leave Requests') }}
                    </a>

                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('Work Schedule') }}
                    </a>

                    <div class="pt-4 mt-4 border-t">
                        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                            {{ __('Documents') }}
                        </h3>

                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            {{ __('Payslips') }}
                        </a>

                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            {{ __('Contracts') }}
                        </a>

                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            {{ __('Tax Documents') }}
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>