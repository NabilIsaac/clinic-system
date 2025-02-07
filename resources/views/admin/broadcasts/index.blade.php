@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Send Broadcast Message</h2>

               
                <form action="{{ route('admin.broadcasts.send') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Recipients
                        </label>
                        <select name="recipient_type" class="w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">All Users</option>
                            <option value="patients">Patients Only</option>
                            <option value="employees">Employees Only</option>
                        </select>
                        @error('recipient_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Message
                        </label>
                        <textarea 
                            name="message" 
                            rows="4" 
                            class="w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Enter your message here..."
                        >{{ old('message') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Maximum 918 characters</p>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Send Broadcast
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection