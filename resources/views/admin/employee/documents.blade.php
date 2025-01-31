@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">{{ __('Documents') }}</h2>
            <div class="flex space-x-3">
                <input type="text" name="search" id="search" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Search documents...">
            </div>
        </div>

        <!-- Document Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Payslips -->
            <a href="{{ route('employee.documents.payslips') }}" class="block p-6 bg-white border rounded-lg hover:bg-gray-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Payslips</h3>
                        <p class="mt-1 text-sm text-gray-500">View and download your monthly payslips</p>
                    </div>
                </div>
            </a>

            <!-- Contracts -->
            <a href="{{ route('employee.documents.contracts') }}" class="block p-6 bg-white border rounded-lg hover:bg-gray-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Contracts</h3>
                        <p class="mt-1 text-sm text-gray-500">Access your employment contracts</p>
                    </div>
                </div>
            </a>

            <!-- Tax Documents -->
            <a href="{{ route('employee.documents.tax-documents') }}" class="block p-6 bg-white border rounded-lg hover:bg-gray-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Tax Documents</h3>
                        <p class="mt-1 text-sm text-gray-500">View your tax forms and documents</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Documents -->
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Documents</h3>
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    <li>
                        <a href="#" class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="ml-3 text-sm font-medium text-blue-600">January 2025 Payslip</p>
                                    </div>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <p class="text-sm text-gray-500">Added 2 days ago</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="ml-3 text-sm font-medium text-blue-600">Employment Contract 2025</p>
                                    </div>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <p class="text-sm text-gray-500">Added 1 week ago</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="ml-3 text-sm font-medium text-blue-600">W-2 Form 2024</p>
                                    </div>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <p class="text-sm text-gray-500">Added 2 weeks ago</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
