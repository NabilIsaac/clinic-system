@extends('layouts.app')

@section('content')
<div class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Shopping Cart</h2>
                
                @if(count($cart) > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($cart as $index => $item)
                        <div class="py-6 flex items-center">
                            <div class="flex-shrink-0 w-24 h-24 rounded-md overflow-hidden">
                                <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="ml-6 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">{{ $item['name'] }}</h3>
                                        <p class="mt-1 text-sm text-gray-500">Price: ${{ number_format($item['price'], 2) }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center border rounded-md">
                                            <button class="px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                            <span class="px-3 py-1 text-sm">{{ $item['quantity'] }}</span>
                                            <button class="px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </span>
                                        <form action="{{ route('shop.cart.remove', $index) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-500 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8 border-t pt-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-600">Subtotal</p>
                                <p class="text-lg font-medium text-gray-900">
                                    ${{ number_format(collect($cart)->sum(function($item) { 
                                        return $item['price'] * $item['quantity']; 
                                    }), 2) }}
                                </p>
                            </div>
                            <a href="{{ route('shop.checkout') }}" 
                               class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="mt-4 text-sm text-gray-500">Your cart is empty</p>
                        <a href="{{ route('shop.index') }}" 
                           class="mt-4 inline-flex items-center text-sm text-blue-600 hover:text-blue-500">
                            Continue Shopping
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection