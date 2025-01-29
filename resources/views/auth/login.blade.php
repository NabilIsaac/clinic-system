@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex">
    <!-- Left side - Login Form -->
    <div class="flex-1 flex flex-col justify-center px-4 sm:px-6 lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm">
            <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Welcome back</h2>
            <p class="mt-2 mb-8 text-sm leading-6 text-gray-500">
                Please log in to gain access to your account
            </p>

            <div class="">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                    class="block w-full h-12 rounded-lg border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                    class="block w-full h-12 rounded-lg border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                                <label for="remember_me" class="ml-3 block text-sm leading-6 text-gray-700">Remember me</label>
                            </div>

                            @if (Route::has('password.request'))
                            <div class="text-sm leading-6">
                                <a href="{{ route('password.request') }}" class="font-semibold text-blue-600 hover:text-blue-500">
                                    Forgot password?
                                </a>
                            </div>
                            @endif
                        </div>

                        <div>
                            <button type="submit"
                                class="flex w-full h-12 justify-center items-center rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                Sign in
                            </button>
                        </div>
                    </div>
                </form>

                <!-- <p class="mt-10 text-start pt-3 text-sm text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-semibold leading-6 text-blue-600 hover:text-blue-500">
                        Sign up
                    </a>
                </p> -->
            </div>
        </div>
    </div>

    <!-- Right side - Decorative -->
    <div class="hidden flex-1 lg:block relative bg-white">
        <div class="absolute inset-0 flex flex-col items-center justify-center">
            <div class="w-full max-w-md px-8">
                <img src="{{ asset('assets/images/logo.jpeg') }}" class="w-32 h-32 object-cover rounded-lg" alt="">
                <h2 class="mt-6 text-2xl font-bold text-gray-900">MediCare Plus</h2>
                <p class="mt-4 text-lg text-gray-600">Your trusted healthcare management system. Access your medical records, appointments, and prescriptions all in one place.</p>
                
                <div class="mt-8 space-y-4">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-3 text-gray-700">Secure patient records</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-3 text-gray-700">Easy appointment scheduling</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-3 text-gray-700">Digital prescriptions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection