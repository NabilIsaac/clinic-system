@extends('layouts.app')

@section('content')
<div class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center space-x-4 mb-4">
            <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </button>
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Checkout</h1>
            </div>
        </div>
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
            <!-- Order summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                        <div class="divide-y divide-gray-200">
                            @foreach($cart as $item)
                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                            <div class="py-4 flex">
                                <div class="flex-shrink-0 w-20 h-20 rounded-md overflow-hidden">
                                    <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <h3 class="text-sm font-medium text-gray-900">{{ $item['name'] }}</h3>
                                        <p class="text-sm font-medium text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Qty {{ $item['quantity'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 border-t pt-6">
                            <div class="flex justify-between text-sm">
                                <p class="text-gray-600">Subtotal</p>
                                <p class="font-medium text-gray-900">${{ number_format($subtotal, 2) }}</p>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <p class="text-gray-600">Shipping</p>
                                <p class="font-medium text-gray-900">$0.00</p>
                            </div>
                            <div class="flex justify-between text-sm font-medium mt-4 pt-4 border-t">
                                <p class="text-gray-900">Total</p>
                                <p class="text-gray-900">${{ number_format($subtotal, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment form -->
            <div class="mt-8 lg:mt-0">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Delivery Information</h2>
                        {{-- {{ route('shop.checkout.process') }} --}}
                        <form action="{{ route('shop.orders.store') }}" method="POST" id="paymentForm">
                            @csrf
                            <div class="space-y-6">
                                <!-- Delivery Location -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Delivery Address</label>
                                    <textarea name="delivery_address" rows="3" required
                                        class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    >{{ old('delivery_address', auth()->user()->address ?? '') }}</textarea>
                                </div>
            
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="tel" name="phone" required
                                        value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                        class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
            
                                <!-- Hidden fields for Paystack -->
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                <input type="hidden" name="amount" value="{{ $subtotal * 100 }}"> {{-- Amount in kobo --}}
                                <input type="hidden" name="reference" value="{{ Str::random(16) }}">
                                <input type="hidden" name="currency" value="GHS">
            
                                <button type="button" onclick="payWithPaystack()" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Pay Now (GHS{{ number_format($subtotal, 2) }})
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
function payWithPaystack() {
    let handler = PaystackPop.setup({
        key: '{{ config('services.paystack.public_key') }}', // Replace with your public key
        email: '{{ auth()->user()->email }}',
        amount: {{ $subtotal * 100 }}, // Amount in kobo
        currency: 'GHS',
        ref: '{{ Str::random(16) }}',
        callback: function(response) {
            // Insert the transaction reference into a hidden field
            let form = document.getElementById('paymentForm');
            let referenceInput = document.createElement('input');
            referenceInput.type = 'hidden';
            referenceInput.name = 'payment_reference';
            referenceInput.value = response.reference;
            form.appendChild(referenceInput);
            
            // Submit the form
            form.submit();
        },
        onClose: function() {
            alert('Transaction was not completed, window closed.');
        }
    });
    handler.openIframe();
}
</script>
@endpush
@endsection