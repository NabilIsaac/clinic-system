@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <!-- Left side - Registration Form -->
    <div class="flex-1 flex flex-col justify-center px-4 sm:px-6 lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm">
            <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Create an account</h2>
            <p class="mt-2 text-sm leading-6 text-gray-500">
                Join us to manage your healthcare journey
            </p>

            <div class="mt-10">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Full Name</label>
                            <div class="mt-2">
                                <input id="name" name="name" type="text" required value="{{ old('name') }}"
                                    class="block w-full h-11 rounded-lg border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                    class="block w-full h-11 rounded-lg border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone Number</label>
                            <div class="mt-2">
                                <input id="phone" name="phone" type="tel" required value="{{ old('phone') }}"
                                    class="block w-full h-11 rounded-lg border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" required autocomplete="new-password"
                                    class="block w-full h-11 rounded-lg border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                            <div class="mt-2">
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                    class="block w-full h-11 rounded-lg border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="flex w-full h-11 justify-center items-center rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                Register
                            </button>
                        </div>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm text-gray-500">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-semibold leading-6 text-blue-600 hover:text-blue-500">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Right side - Decorative -->
    <div class="relative hidden flex-1 lg:block">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-50 to-blue-100 flex flex-col items-center justify-center p-8">
            <div class="w-full max-w-md">
                <x-application-logo class="w-20 h-20 text-blue-600" />
                <h2 class="mt-6 text-2xl font-bold text-gray-900">MediCare Plus</h2>
                <p class="mt-4 text-lg text-gray-600">Join our healthcare platform and experience seamless medical care management.</p>
                
                <div class="mt-8 space-y-4">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-3 text-gray-700">Easy online appointment booking</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-3 text-gray-700">Access to medical history</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-3 text-gray-700">Secure communication with doctors</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
