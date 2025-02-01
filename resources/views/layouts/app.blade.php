<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="flex bg-gray-50">
        @auth
            @include('layouts.sidebar')
        @endauth

        <!-- Page Content -->
        <main class="@auth flex-1 @endauth">
            <div class="container overflow-y-scroll mx-auto px-4 py-6">
                <x-alerts />
                @yield('content')
                @role('doctor')
                    <x-checkup-button />
                @endrole
            </div>
        </main>
    </div>
    @livewireScripts
    @stack('scripts')
</body>
</html>