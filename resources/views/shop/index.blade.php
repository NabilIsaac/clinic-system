@extends('layouts.app')

@section('content')

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white rounded-xl shadow-sm mb-8 p-6">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome to Our Medical Shop</h1>
                    <p class="text-gray-600 max-w-2xl mx-auto">Find quality medical supplies and over-the-counter medicines for your healthcare needs.</p>
                </div>
            </div>

            <!-- Products Section -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Medical Products</h2>
                    <div class="flex space-x-2">
                        <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option>All Categories</option>
                            <option>Medical Supplies</option>
                            <option>Equipment</option>
                            <option>Accessories</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($products as $product)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="relative">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                    class="w-full h-48 object-cover">
                                @if($product->stock_quantity <= $product->reorder_level)
                                    <span class="absolute top-2 right-2 bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                        Low Stock
                                    </span>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-500 h-12 overflow-hidden">
                                        {{ Str::limit($product->description, 50) }}
                                    </p>
                                </div>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                    <form action="{{ route('shop.cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <input type="hidden" name="type" value="product">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
                            <p class="text-gray-500">No products available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Medicines Section -->
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Over-the-Counter Medicines</h2>
                    <div class="flex space-x-2">
                        <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option>All Categories</option>
                            <option>Pain Relief</option>
                            <option>Cold & Flu</option>
                            <option>Vitamins</option>
                        </select>
                    </div>
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
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $drug->name }}</h3>
                                    <p class="text-sm text-gray-500 h-12 overflow-hidden">
                                        {{ Str::limit($drug->description, 50) }}
                                    </p>
                                </div>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-xl font-bold text-gray-900">${{ number_format($drug->price, 2) }}</span>
                                    <form action="{{ route('shop.cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $drug->id }}">
                                        <input type="hidden" name="type" value="drug">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
            </div>
        </div>
    </div>

@endsection