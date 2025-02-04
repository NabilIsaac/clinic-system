@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center space-x-4 p-4 mb-4">
        <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </button>
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Add New Checkup</h1>
            <p class="text-sm text-gray-500">Enter checkup information below.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <form action="{{ route('doctor.checkups.store') }}" method="POST" x-data="checkupForm()">
            @csrf
            
            <!-- Patient Selection -->
            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Patient Information</h3>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label for="patient_id" class="block text-sm font-medium text-gray-700">Select Patient</label>
                                <select name="patient_id" id="patient_id" required
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">Select a patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }} - {{ $patient->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkup Details -->
            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Checkup Details</h3>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Visit</label>
                                <select name="reason" id="reason" required
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">Select reason</option>
                                    <option value="knee_pain">Knee Pain</option>
                                    <option value="back_pain">Back Pain</option>
                                    <option value="neck_pain">Neck Pain</option>
                                    <option value="stroke">Stroke</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="bp" class="block text-sm font-medium text-gray-700">Blood Pressure</label>
                                <input type="text" name="bp" id="bp" placeholder="120/80"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6">
                                <label for="history" class="block text-sm font-medium text-gray-700">Visit History</label>
                                <textarea name="history" id="history" rows="3"
                                    class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medications -->
            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Medications</h3>
                        <button type="button" @click="addMedication()"
                            class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Add Medication
                        </button>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <template x-for="(med, index) in medications" :key="index">
                            <div class="grid grid-cols-6 gap-6 mb-4">
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Medicine</label>
                                    <select x-model="med.drug_id" :name="'medications['+index+'][drug_id]'"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">Select medicine</option>
                                        @foreach($drugs as $drug)
                                            <option value="{{ $drug->id }}">{{ $drug->name }} - ${{ $drug->price }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                    <input type="number" x-model="med.quantity" :name="'medications['+index+'][quantity]'"
                                        @change="calculateTotals()"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Dosage</label>
                                    <input type="text" x-model="med.dosage" :name="'medications['+index+'][dosage]'"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <button type="button" @click="removeMedication(index)"
                                        class="mt-1 inline-flex items-center px-3 py-2 border text-red-500 border-transparent text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                          </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <div class="text-right">
                            <span class="text-lg font-medium">Total Medications: $<span x-text="medicationsTotal"></span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Products</h3>
                        <button type="button" @click="addProduct()"
                            class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Add Product
                        </button>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <template x-for="(prod, index) in products" :key="index">
                            <div class="grid grid-cols-6 gap-6 mb-4">
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Product</label>
                                    <select x-model="prod.product_id" :name="'products['+index+'][product_id]'"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">Select product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} - ${{ $product->price }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                    <input type="number" x-model="prod.quantity" :name="'products['+index+'][quantity]'"
                                        @change="calculateTotals()"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <button type="button" @click="removeProduct(index)"
                                        class="mt-1 inline-flex items-center px-3 py-2 text-red-500 border border-transparent text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                          </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <div class="text-right">
                            <span class="text-lg font-medium">Total Products: $<span x-text="productsTotal"></span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Comments -->
            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Additional Comments</h3>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <textarea name="comments" id="comments" rows="4"
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
            </div>

            <!-- Grand Total -->
            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="text-right">
                    <span class="text-xl font-bold">Grand Total: $<span x-text="grandTotal"></span></span>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex justify-end">
                <button type="submit"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create Checkup
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function checkupForm() {
        return {
            medications: [],
            products: [],
            medicationsTotal: 0,
            productsTotal: 0,
            grandTotal: 0,

            addMedication() {
                this.medications.push({
                    drug_id: '',
                    quantity: 1,
                    dosage: ''
                });
            },

            removeMedication(index) {
                this.medications.splice(index, 1);
                this.calculateTotals();
            },

            addProduct() {
                this.products.push({
                    product_id: '',
                    quantity: 1
                });
            },

            removeProduct(index) {
                this.products.splice(index, 1);
                this.calculateTotals();
            },

            calculateTotals() {
                // Calculate medications total
                this.medicationsTotal = this.medications.reduce((total, med) => {
                    const drug = @json($drugs).find(d => d.id == med.drug_id);
                    return total + (drug ? drug.price * med.quantity : 0);
                }, 0);

                // Calculate products total
                this.productsTotal = this.products.reduce((total, prod) => {
                    const product = @json($products).find(p => p.id == prod.product_id);
                    return total + (product ? product.price * prod.quantity : 0);
                }, 0);

                // Calculate grand total
                this.grandTotal = this.medicationsTotal + this.productsTotal;
            }
        }
    }
</script>
@endpush
@endsection