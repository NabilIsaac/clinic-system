@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center space-x-4 p-4 mb-4">
                <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Order #{{ $order->reference }}</h1>
                    <p class="text-sm text-gray-500">View and manage order details.</p>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Order #{{ $order->reference }}</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($order->status === 'delivered') bg-green-100 text-green-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Order Details -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Order Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-600">Order Date</p>
                                    <p class="font-medium">{{ $order->created_at->format('M d, Y H:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Payment Status</p>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                        @if($order->payment_status === 'paid') 
                                            bg-green-100 text-green-800
                                        @elseif($order->payment_status === 'pending')
                                            bg-yellow-100 text-yellow-800
                                        @elseif($order->payment_status === 'failed')
                                            bg-red-100 text-red-800
                                        @else
                                            bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                                @if($order->tracking_number)
                                <div>
                                    <p class="text-sm text-gray-600">Tracking Number</p>
                                    <p class="font-medium">{{ $order->tracking_number }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Shipping Information</h3>
                            <p class="whitespace-pre-line">{{ $order->shipping_address }}</p>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                        <div class="space-y-4">
                            @foreach($order->items as $product)
                            <div class="flex items-center justify-between border-b pb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0 w-16 h-16">
                                        <img src="{{ $product->product->image_url }}" alt="{{ $product->product->name }}" 
                                            class="w-full h-full object-cover rounded-md">
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $product->product->name }}</p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $product->product_type === 'App\Models\Drug' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $product->product_type === 'App\Models\Drug' ? 'Drug' : 'Product' }}
                                            </span>
                                            <p class="text-sm text-gray-600">Quantity: {{ $product->quantity }}</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="font-medium">${{ number_format($product->price * $product->quantity, 2) }}</p>
                            </div>
                            @endforeach

                            {{-- @foreach($order->drugs as $drug)
                            <div class="flex justify-between border-b pb-4">
                                <div>
                                    <p class="font-medium">{{ $drug->name }}</p>
                                    <p class="text-sm text-gray-600">Quantity: {{ $drug->pivot->quantity }}</p>
                                </div>
                                <p class="font-medium">${{ $drug->pivot->price * $drug->pivot->quantity }}</p>
                            </div>
                            @endforeach --}}

                            <div class="flex justify-between font-bold text-lg pt-4">
                                <span>Total</span>
                                <span>${{ $order->total_amount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection