@extends('layouts.app')
@section('content')
   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Leave Management') }}
                </h2>
            </div>
            

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Range</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($leaves as $leave)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $leave->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $leave->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $leave->start_date->format('M d, Y') }} - {{ $leave->end_date->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($leave->reason, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($leave->status === 'approved') bg-green-100 text-green-800
                                            @elseif($leave->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ ucfirst($leave->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($leave->status === 'pending')
                                            <form action="{{ route('admin.leaves.approve', $leave) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.leaves.reject', $leave) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No leave requests found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $leaves->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection