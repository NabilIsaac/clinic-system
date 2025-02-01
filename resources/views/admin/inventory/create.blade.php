@extends('layouts.app')

@section('content')
    <div class="mx-auto py-6 sm:px-6 lg:px-8">
        <div class="">
            <div class="flex items-center space-x-4 p-4 mb-4">
                <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>
                <div class="px-4 sm:px-0">
                    <h3 class="text-xl font-semibold text-gray-900">Add New Item</h3>
                    <p class="text-sm text-gray-500">
                        Add a new item to your inventory. Fill in all the required information below.
                    </p>
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('admin.inventory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 grid grid-cols-2 gap-4 bg-white sm:p-6">
                            <!-- Item Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Item Type
                                </label>
                                <div class="mt-1">
                                    <select name="type" id="type" class="mt-1 block w-full h-10 px-2 border pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="drug">Medicine/Drug</option>
                                        <option value="product">Product/Supply</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Name
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full h-10 px-2 border sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>

                            <!-- Generic Name (for drugs) -->
                            <div id="genericNameField">
                                <label for="generic_name" class="block text-sm font-medium text-gray-700">
                                    Generic Name
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="generic_name" id="generic_name" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full h-10 px-2 border sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">
                                    Category
                                </label>
                                <div class="mt-1">
                                    <select name="category_id" id="category_id" class="mt-1 block w-full h-10 px-2 border pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" required>
                                        <option value="">Select a category</option>
                                        <!-- Drug Categories -->
                                        <optgroup label="Medicine Categories" id="drugCategories">
                                            @foreach($drugCategories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </optgroup>
                                        <!-- Product Categories -->
                                        <optgroup label="Product Categories" id="productCategories">
                                            @foreach($productCategories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">
                                    Description
                                </label>
                                <div class="mt-1">
                                    <textarea name="description" id="description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full h-10 px-2 border sm:text-sm border-gray-300 rounded-md"></textarea>
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
                                    <input type="number" name="price" id="price" step="0.01" min="0" class="focus:ring-blue-500 focus:border-blue-500 block w-full h-10 px-2 border pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>

                            <!-- Stock Quantity -->
                            <div>
                                <label for="stock_quantity" class="block text-sm font-medium text-gray-700">
                                    Stock Quantity
                                </label>
                                <div class="mt-1">
                                    <input type="number" name="stock_quantity" id="stock_quantity" min="0" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full h-10 px-2 border sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>

                            <!-- Unit -->
                            <div>
                                <label for="unit" class="block text-sm font-medium text-gray-700">
                                    Unit
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="unit" id="unit" placeholder="e.g., tablets, bottles, pieces" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full h-10 px-2 border sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>

                            <!-- SKU -->
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700">
                                    SKU
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="sku" id="sku" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full h-10 px-2 border sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>

                            <!-- Reorder Level -->
                            <div>
                                <label for="reorder_level" class="block text-sm font-medium text-gray-700">
                                    Reorder Level
                                </label>
                                <div class="mt-1">
                                    <input type="number" name="reorder_level" id="reorder_level" min="0" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full h-10 px-2 border sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Minimum quantity before reorder alert is triggered
                                </p>
                            </div>

                            <!-- Image Upload -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Item Image
                                </label>
                                <div class="mt-1 flex items-center">
                                    <div class="w-32 h-32 border-2 border-gray-300 border-dashed rounded-lg overflow-hidden">
                                        <img id="preview" src="{{ asset('assets/images/placeholder.jpeg') }}" alt="Preview" class="w-full h-full object-cover">
                                    </div>
                                    <div class="ml-5">
                                        <div class="relative">
                                            <input type="file" name="image" id="image" accept="image/*" class="sr-only" onchange="previewImage(event)">
                                            <label for="image" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Upload Image
                                            </label>
                                        </div>
                                        <p class="mt-2 text-xs text-gray-500">
                                            PNG, JPG, GIF up to 2MB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 border-b rounded-b-lg bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Add Item
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const genericNameField = document.getElementById('genericNameField');
            const drugCategories = document.getElementById('drugCategories');
            const productCategories = document.getElementById('productCategories');

            function updateFormFields() {
                const selectedType = typeSelect.value;
                
                // Toggle Generic Name field
                if (selectedType === 'drug') {
                    genericNameField.style.display = 'block';
                    document.getElementById('generic_name').required = true;
                    drugCategories.style.display = '';
                    productCategories.style.display = 'none';
                } else {
                    genericNameField.style.display = 'none';
                    document.getElementById('generic_name').required = false;
                    drugCategories.style.display = 'none';
                    productCategories.style.display = '';
                }
            }

            // Initial setup
            updateFormFields();

            // Listen for changes
            typeSelect.addEventListener('change', updateFormFields);
        });

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    @endpush
@endsection
