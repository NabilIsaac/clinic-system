@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Create New Bill</h1>
        </div>
    </div>

    <form action="{{ route('admin.billing.store') }}" method="POST" class="mt-8 space-y-6" 
    x-data="{ 
        checkupItems: [], 
        totalAmount: 0,
        async fetchPatientItems(patientId) {
            if (!patientId) return;
            const response = await fetch(`/admin/billing/patient-items/${patientId}`);
            const data = await response.json();
            this.checkupItems = data.items;
            this.totalAmount = data.total_amount;
        }
    }">
        @csrf
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Bill Information</h3>
                    <p class="mt-1 text-sm text-gray-500">Basic information about the bill.</p>
                </div>
                
                <div class="mt-5 md:mt-0 md:col-span-2 space-y-6">
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                        <select id="patient_id" name="patient_id" required
                        @change="fetchPatientItems($event.target.value)"
                        class="mt-1 block w-full pl-3 pr-10 py-2 shadow-sm text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                        <input type="date" name="due_date" id="due_date" required
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            value="{{ old('due_date') }}">
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea id="notes" name="notes" rows="3"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Bill Items</h3>
                    <p class="mt-1 text-sm text-gray-500">Add items to the bill.</p>
                </div>
                
                <div class="mt-5 md:mt-0 md:col-span-2">
                    {{-- <div id="items-container" class="space-y-4">
                        <div class="item-row grid grid-cols-12 gap-4">
                            <div class="col-span-6">
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" name="items[0][description]" required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="number" step="0.01" name="items[0][amount]" required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" name="items[0][quantity]" required value="1" min="1"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-1 flex items-end">
                                <button type="button" onclick="removeItem(this)"
                                    class="mb-1 text-red-600 hover:text-red-900">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" onclick="addItem()"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Item
                        </button>
                    </div> --}}
                    <div id="items-container" class="space-y-4">
                        <template x-if="checkupItems.length === 0">
                            <p class="text-gray-500 text-sm">Select a patient to view their items</p>
                        </template>
                        
                        <template x-for="(item, index) in checkupItems" :key="index">
                            <div class="item-row grid grid-cols-12 gap-4 border-b border-gray-200 py-4">
                                <div class="col-span-4">
                                    <label class="block text-sm font-medium text-gray-700">Item</label>
                                    <input type="text" x-model="item.name" readonly
                                        class="mt-1 bg-gray-50 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Type</label>
                                    <input type="text" x-model="item.type" readonly
                                        class="mt-1 bg-gray-50 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                    <input type="number" x-model="item.quantity" readonly
                                        class="mt-1 bg-gray-50 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Unit Price</label>
                                    <input type="number" x-model="item.unit_price" readonly
                                        class="mt-1 bg-gray-50 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Total</label>
                                    <input type="number" x-model="item.total_price" readonly
                                        class="mt-1 bg-gray-50 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <input type="hidden" :name="'items['+index+'][name]'" x-model="item.name">
                                    <input type="hidden" :name="'items['+index+'][type]'" x-model="item.type">
                                    <input type="hidden" :name="'items['+index+'][quantity]'" x-model="item.quantity">
                                    <input type="hidden" :name="'items['+index+'][unit_price]'" x-model="item.unit_price">
                                    <input type="hidden" :name="'items['+index+'][total_price]'" x-model="item.total_price">
                                </div>
                            </div>
                            
                        </template>
                    
                        <div class="flex justify-end pt-4">
                            <div class="text-lg font-bold">
                                Total Amount: $<span x-text="totalAmount.toFixed(2)"></span>
                                <input type="hidden" name="total_amount" x-model="totalAmount">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Create Bill
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let itemCount = 1;

    function addItem() {
        const template = `
            <div class="item-row grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" name="items[${itemCount}][description]" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" step="0.01" name="items[${itemCount}][amount]" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="items[${itemCount}][quantity]" required value="1" min="1"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-1 flex items-end">
                    <button type="button" onclick="removeItem(this)"
                        class="mb-1 text-red-600 hover:text-red-900">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        document.getElementById('items-container').insertAdjacentHTML('beforeend', template);
        itemCount++;
    }

    function removeItem(button) {
        const row = button.closest('.item-row');
        if (document.querySelectorAll('.item-row').length > 1) {
            row.remove();
        }
    }
</script>
@endpush
@endsection

{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Create New Utility Bill</h1>
        </div>
    </div>

    <form action="{{ route('admin.billing.store') }}" method="POST" class="mt-8 space-y-6">
        @csrf
        
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Bill Information</h3>
                    <p class="mt-1 text-sm text-gray-500">Basic information about the utility bill.</p>
                </div>
                
                <div class="mt-5 md:mt-0 md:col-span-2 space-y-6">
                    <div>
                        <label for="bill_type" class="block text-sm font-medium text-gray-700">Bill Type</label>
                        <select id="bill_type" name="bill_type" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Select Bill Type</option>
                            <option value="water">Water Bill</option>
                            <option value="electricity">Electricity Bill</option>
                            <option value="gas">Gas Bill</option>
                            <option value="internet">Internet Bill</option>
                            <option value="phone">Phone Bill</option>
                            <option value="other">Other Utility</option>
                        </select>
                    </div>

                    <div>
                        <label for="bill_period" class="block text-sm font-medium text-gray-700">Billing Period</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-500">From</label>
                                <input type="date" name="period_start" id="period_start" required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ old('period_start') }}">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500">To</label>
                                <input type="date" name="period_end" id="period_end" required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ old('period_end') }}">
                            </div>
                        </div>
                    </div>

                    {{-- <div>
                        <label for="bill_number" class="block text-sm font-medium text-gray-700">Bill Number/Reference</label>
                        <input type="text" name="bill_number" id="bill_number" required
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            value="{{ old('bill_number') }}">
                    </div> --}}

                    {{-- <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                        <input type="date" name="due_date" id="due_date" required
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            value="{{ old('due_date') }}">
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Total Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="amount" id="amount" step="0.01" required
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                placeholder="0.00">
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea id="notes" name="notes" rows="3"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Any additional information about the bill">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="button" onclick="history.back()"
                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancel
            </button>
            <button type="submit"
                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Create Bill
            </button>
        </div>
    </form>
</div>
@endsection --}}