@extends('layouts.app')

@section('content')
<div class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section with Cart Badge -->
        <div class="flex justify-between items-center mb-6">
            <div class="">
                <h1 class="text-2xl font-semibold text-gray-900 mb-2">Welcome to Our Medical Shop</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('shop.orders.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    My Orders
                </a>
                <a href="{{ route('shop.cart') }}" class="text-gray-600 hover:text-gray-900 flex items-center relative">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Cart
                    @if(session()->has('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
            </div>
        </div>

        <div class="flex justify-between items-center mb-2">
            <h2 class="text-base font-semibold text-gray-900">Medical Products</h2>
            {{-- <div class="flex space-x-2">
                <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option>All Categories</option>
                    <option>Medical Supplies</option>
                    <option>Equipment</option>
                    <option>Accessories</option>
                </select>
            </div> --}}
        </div>
        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 mb-12 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4">
                        @if($product)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <h3 class="mt-4 text-sm font-semibold text-gray-900">{{ $product->name }}</h3>
                        <p class="text-xs text-gray-600">{{ Str::limit($product->description, 100) }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-sm font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                            <form action="{{ route('shop.cart.add', $product) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="type" value="product">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                class="inline-flex items-center px-2 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/>
                                </svg>
                                Add to Cart
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                    <p class="mt-1 text-sm text-gray-500">Check back later for new products.</p>
                </div>
            @endforelse
        </div>

        <div class="flex justify-between items-center mb-2">
            <h2 class="text-base font-semibold text-gray-900">Over-the-Counter Medicines</h2>
            {{-- <div class="flex space-x-2">
                <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option>All Categories</option>
                    <option>Pain Relief</option>
                    <option>Cold & Flu</option>
                    <option>Vitamins</option>
                </select>
            </div> --}}
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($drugs as $drug)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <div class="relative">
                        <img src="{{ $drug->image_url }}" alt="{{ $drug->name }}" 
                            class="w-full h-48 object-cover">
                        @if($drug->stock_quantity <= $drug->reorder_level)
                            <span class="absolute top-2 right-2 bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                Low Stock
                            </span>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="mb-2">
                            <h3 class="text-sm font-semibold text-gray-900">{{ $drug->name }}</h3>
                            <p class="text-xs text-gray-500 h-12 overflow-hidden">
                                {{ Str::limit($drug->description, 50) }}
                            </p>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-sm font-bold text-gray-900">${{ number_format($drug->price, 2) }}</span>
                            <form action="{{ route('shop.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $drug->id }}">
                                <input type="hidden" name="type" value="drug">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                    class="inline-flex items-center px-2 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/>
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-12">
                    <p class="text-gray-500">No medicines available at the moment.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection