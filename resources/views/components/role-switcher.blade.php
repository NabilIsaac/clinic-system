<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" type="button" class="flex items-center w-full px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <span>Switch Role</span>
        <svg class="w-5 h-5 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" @click.away="open = false" class="absolute left-0 w-full mt-2 origin-top-right rounded-md shadow-lg">
        <div class="py-1 bg-white rounded-md shadow-xs">
            @foreach(auth()->user()->roles as $role)
                <form method="POST" action="{{ route('user.switch-role') }}">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role->name }}">
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ session('current_role') === $role->name ? 'bg-gray-50' : '' }}">
                        <span class="mr-2">{{ ucfirst($role->name) }}</span>
                        @if(session('current_role') === $role->name)
                            <svg class="w-4 h-4 ml-auto text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </button>
                </form>
            @endforeach
        </div>
    </div>
</div>