@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">My Prescriptions</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($prescriptions as $prescription)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                Dr. {{ $prescription->doctor->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $prescription->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $prescription->status === 'active' ? 'bg-green-100 text-green-800' : 
                                       ($prescription->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($prescription->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('patient.prescriptions.show', $prescription) }}" 
                                   class="text-blue-600 hover:text-blue-900 mr-3">View Details</a>
                                <a href="{{ route('patient.prescriptions.download', $prescription) }}" 
                                   class="text-green-600 hover:text-green-900">Download PDF</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No prescriptions found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $prescriptions->links() }}
        </div>
    </div>
</div>
@endsection