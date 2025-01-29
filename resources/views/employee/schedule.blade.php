@extends('layouts.app')

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
            <!-- Monday -->
            <div class="border rounded-lg p-4">
                <h3 class="font-medium text-gray-900 mb-2">Monday</h3>
                <div class="space-y-2">
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-sm font-medium text-blue-900">9:00 AM - 12:00 PM</p>
                        <p class="text-xs text-blue-700">Morning Shift</p>
                    </div>
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-sm font-medium text-blue-900">1:00 PM - 5:00 PM</p>
                        <p class="text-xs text-blue-700">Afternoon Shift</p>
                    </div>
                </div>
            </div>

            <!-- Tuesday -->
            <div class="border rounded-lg p-4">
                <h3 class="font-medium text-gray-900 mb-2">Tuesday</h3>
                <div class="space-y-2">
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-sm font-medium text-blue-900">9:00 AM - 12:00 PM</p>
                        <p class="text-xs text-blue-700">Morning Shift</p>
                    </div>
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-sm font-medium text-blue-900">1:00 PM - 5:00 PM</p>
                        <p class="text-xs text-blue-700">Afternoon Shift</p>
                    </div>
                </div>
            </div>

            <!-- Wednesday -->
            <div class="border rounded-lg p-4">
                <h3 class="font-medium text-gray-900 mb-2">Wednesday</h3>
                <div class="space-y-2">
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-sm font-medium text-blue-900">9:00 AM - 12:00 PM</p>
                        <p class="text-xs text-blue-700">Morning Shift</p>
                    </div>
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-sm font-medium text-blue-900">1:00 PM - 5:00 PM</p>
                        <p class="text-xs text-blue-700">Afternoon Shift</p>
                    </div>
                </div>
            </div>

            <!-- Thursday -->
            <div class="border rounded-lg p-4">
                <h3 class="font-medium text-gray-900 mb-2">Thursday</h3>
                <div class="space-y-2">
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-sm font-medium text-blue-900">9:00 AM - 12:00 PM</p>
                        <p class="text-xs text-blue-700">Morning Shift</p>
                    </div>
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-sm font-medium text-blue-900">1:00 PM - 5:00 PM</p>
                        <p class="text-xs text-blue-700">Afternoon Shift</p>
                    </div>
                </div>
            </div>

            <!-- Friday -->
            <div class="border rounded-lg p-4">
                <h3 class="font-medium text-gray-900 mb-2">Friday</h3>
                <div class="space-y-2">
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-sm font-medium text-blue-900">9:00 AM - 12:00 PM</p>
                        <p class="text-xs text-blue-700">Morning Shift</p>
                    </div>
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-sm font-medium text-blue-900">1:00 PM - 5:00 PM</p>
                        <p class="text-xs text-blue-700">Afternoon Shift</p>
                    </div>
                </div>
            </div>

            <!-- Saturday -->
            <div class="border rounded-lg p-4">
                <h3 class="font-medium text-gray-900 mb-2">Saturday</h3>
                <div class="bg-gray-50 p-2 rounded">
                    <p class="text-sm text-gray-500">Off Day</p>
                </div>
            </div>

            <!-- Sunday -->
            <div class="border rounded-lg p-4">
                <h3 class="font-medium text-gray-900 mb-2">Sunday</h3>
                <div class="bg-gray-50 p-2 rounded">
                    <p class="text-sm text-gray-500">Off Day</p>
                </div>
            </div>
        </div>

        <!-- Weekly Summary -->
        <div class="mt-8 bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Weekly Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Hours</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">40 hours</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Working Days</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">5 days</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Off Days</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">2 days</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
