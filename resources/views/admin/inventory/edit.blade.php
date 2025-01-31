@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Item</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Update the item information below.
                    </p>
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('admin.inventory.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="{{ $type }}">
                    
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Name
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>

                            <!-- Generic Name (for drugs) -->
                            @if($type === 'drug')
                            <div>
                                <label for="generic_name" class="block text-sm font-medium text-gray-700">
                                    Generic Name
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="generic_name" id="generic_name" value="{{ old('generic_name', $item->generic_name) }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>
                            @endif

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">
                                    Category
                                </label>
                                <div class="mt-1">
                                    <select name="category_id" id="category_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">
                                    Description
                                </label>
                                <div class="mt-1">
                                    <textarea name="description" id="description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('description', $item->description) }}</textarea>
                                </div>
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">
                                    Price
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="price" id="price" value="{{ old('price', $item->price) }}" step="0.01" min="0" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>

                            <!-- Stock Quantity -->
                            <div>
                                <label for="stock_quantity" class="block text-sm font-medium text-gray-700">
                                    Stock Quantity
                                </label>
                                <div class="mt-1">
                                    <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $item->stock_quantity) }}" min="0" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>

                            <!-- Unit -->
                            <div>
                                <label for="unit" class="block text-sm font-medium text-gray-700">
                                    Unit
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="unit" id="unit" value="{{ old('unit', $item->unit) }}" placeholder="e.g., tablets, bottles, pieces" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>

                            <!-- SKU -->
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700">
                                    SKU
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="sku" id="sku" value="{{ old('sku', $item->sku) }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>

                            <!-- Reorder Level -->
                            <div>
                                <label for="reorder_level" class="block text-sm font-medium text-gray-700">
                                    Reorder Level
                                </label>
                                <div class="mt-1">
                                    <input type="number" name="reorder_level" id="reorder_level" value="{{ old('reorder_level', $item->reorder_level) }}" min="0" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Minimum quantity before reorder alert is triggered
                                </p>
                            </div>
                        </div>

                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Item
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Stock Adjustment Form -->
                <div class="mt-6">
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Adjust Stock
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>Adjust the stock quantity. Use positive numbers to add stock and negative numbers to remove stock.</p>
                            </div>
                            <form action="{{ route('admin.inventory.adjust-stock', $item->id) }}" method="POST" class="mt-5">
                                @csrf
                                <input type="hidden" name="type" value="{{ $type }}">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="adjustment" class="block text-sm font-medium text-gray-700">Quantity Adjustment</label>
                                        <input type="number" name="adjustment" id="adjustment" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                                        <input type="text" name="reason" id="reason" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Adjust Stock
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
