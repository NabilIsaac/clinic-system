@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">{{ __('Tax Documents') }}</h2>
            <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="2025">2025</option>
                <option value="2024">2024</option>
            </select>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- W-2 Form -->
                <div class="border rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">W-2 Form</h3>
                            <p class="mt-1 text-sm text-gray-500">Wage and Tax Statement</p>
                            <p class="mt-2 text-sm text-gray-700">Tax Year: 2025</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Available
                        </span>
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <button class="text-sm text-blue-600 hover:text-blue-900">View</button>
                        <button class="text-sm text-blue-600 hover:text-blue-900">Download</button>
                    </div>
                </div>

                <!-- 1099 Form -->
                <div class="border rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">1099 Form</h3>
                            <p class="mt-1 text-sm text-gray-500">Miscellaneous Income</p>
                            <p class="mt-2 text-sm text-gray-700">Tax Year: 2025</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <button class="text-sm text-gray-400 cursor-not-allowed">View</button>
                        <button class="text-sm text-gray-400 cursor-not-allowed">Download</button>
                    </div>
                </div>

                <!-- Tax Return -->
                <div class="border rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Tax Return</h3>
                            <p class="mt-1 text-sm text-gray-500">Annual Tax Return Copy</p>
                            <p class="mt-2 text-sm text-gray-700">Tax Year: 2025</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            Processing
                        </span>
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <button class="text-sm text-gray-400 cursor-not-allowed">View</button>
                        <button class="text-sm text-gray-400 cursor-not-allowed">Download</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
