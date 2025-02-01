@if ($items->lastPage() > 1) 
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center justify-between">
            <!-- Page Size Selector -->
            <div class="flex items-center">
                <span class="text-sm text-gray-700">Show</span>
                <select class="mx-2 rounded-md border-gray-300 py-1 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        onchange="window.location.href='?per_page='+this.value">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
                <span class="text-sm text-gray-700">per page</span>
            </div>

            <!-- Pagination Navigation -->
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-700">
                    Showing {{ $items->firstItem() }}-{{ $items->lastItem() }} of {{ $items->total() }} results
                </span>

                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                    @if ($items->onFirstPage())
                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500">
                            Previous
                        </span>
                    @else
                        <a href="{{ $items->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            Previous
                        </a>
                    @endif

                    @for ($i = 1; $i <= $items->lastPage(); $i++)
                        <a href="{{ $items->url($i) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 {{ $i == $items->currentPage() ? 'bg-blue-500 text-white' : '' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    @if ($items->hasMorePages())
                        <a href="{{ $items->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            Next
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500">
                            Next
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </div>
@endif
