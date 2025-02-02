@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center space-x-4 p-4 mb-4">
            <button type="button" onclick="history.back()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </button>
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Add New Patient</h1>
                <p class="text-sm text-gray-500">Enter patient information below.</p>
            </div>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg relative">

            <form method="POST" action="{{ route('nurse.patients.store') }}">
                @csrf
                
                <!-- Personal Information -->
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Personal Information</h3>
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="phone_number" id="phone_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                        </div>

                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="marital_status" class="block text-sm font-medium text-gray-700">Marital Status</label>
                            <select name="marital_status" id="marital_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Select Status</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                                <option value="widowed">Widowed</option>
                            </select>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Medical Information -->
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Medical Information</h3>
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                        <div>
                            <label for="blood_type" class="block text-sm font-medium text-gray-700">Blood Type</label>
                            <select name="blood_type" id="blood_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Select Blood Type</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="allergies" class="block text-sm font-medium text-gray-700">Allergies</label>
                            <textarea name="allergies" id="allergies" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="chronic_diseases" class="block text-sm font-medium text-gray-700">Chronic Diseases</label>
                            <textarea name="chronic_diseases" id="chronic_diseases" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="medical_history" class="block text-sm font-medium text-gray-700">Medical History</label>
                            <textarea name="medical_history" id="medical_history" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Emergency Contact</h3>
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                        <div>
                            <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Contact Name</label>
                            <input type="text" name="emergency_contact_name" id="emergency_contact_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">Contact Phone</label>
                            <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="emergency_contact_relation" class="block text-sm font-medium text-gray-700">Relationship</label>
                            <input type="text" name="emergency_contact_relation" id="emergency_contact_relation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Insurance Information -->
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Insurance Information</h3>
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                        <div>
                            <label for="insurance_company" class="block text-sm font-medium text-gray-700">Insurance Company</label>
                            <input type="text" name="insurance_company" id="insurance_company" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="insurance_number" class="block text-sm font-medium text-gray-700">Insurance Number</label>
                            <input type="text" name="insurance_number" id="insurance_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="policy_number" class="block text-sm font-medium text-gray-700">Policy Number</label>
                            <input type="text" name="policy_number" id="policy_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="member_number" class="block text-sm font-medium text-gray-700">Member Number</label>
                            <input type="text" name="member_number" id="member_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="issued_date" class="block text-sm font-medium text-gray-700">Issue Date</label>
                            <input type="date" name="issued_date" id="issued_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                            <input type="date" name="expiry_date" id="expiry_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                </div>
                <div class="fixed right-4 bottom-4 w-[300px] p-6 bg-white rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">BMI Calculator</h2>
                
                    <!-- Height Input -->
                    <div class="mb-4">
                        <label for="height" class="block text-sm font-medium text-gray-700">Height (cm)</label>
                        <input type="number" step="0.1" id="height" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Enter height in cm">
                    </div>
                
                    <!-- Weight Input -->
                    <div class="mb-4">
                        <label for="weight" class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                        <input type="number" step="0.1" id="weight" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Enter weight in kg">
                    </div>
                
                    <!-- BMI Result -->
                    <div class="mb-4">
                        <label for="bmi" class="block text-sm font-medium text-gray-700">Your BMI</label>
                        <input type="text" id="bmi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm bg-gray-100 text-gray-700" readonly>
                        <p id="bmi_category" class="mt-2 text-sm font-semibold text-blue-600">--</p>
                    </div>
                
                    <button onclick="calculateBMI()" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Calculate</button>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Patient
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const heightInput = document.getElementById("height");
        const weightInput = document.getElementById("weight");
        const bmiOutput = document.getElementById("bmi");
        const bmiCategory = document.getElementById("bmi_category");
        const resetBtn = document.getElementById("resetBtn");
    
        function calculateBMI() {
            const height = parseFloat(heightInput.value);
            const weight = parseFloat(weightInput.value);
    
            if (!height || !weight || height <= 0 || weight <= 0) {
                bmiOutput.value = "";
                bmiCategory.textContent = "Enter valid height and weight";
                bmiCategory.className = "text-sm text-gray-500";
                return;
            }
    
            const heightInMeters = height / 100;
            const bmi = (weight / (heightInMeters * heightInMeters)).toFixed(2);
            bmiOutput.value = bmi;
    
            let category = "";
            let colorClass = "";
    
            if (bmi < 18.5) {
                category = "Underweight";
                colorClass = "text-yellow-500";
            } else if (bmi < 25) {
                category = "Normal weight";
                colorClass = "text-green-500";
            } else if (bmi < 30) {
                category = "Overweight";
                colorClass = "text-orange-500";
            } else {
                category = "Obese";
                colorClass = "text-red-500";
            }
    
            bmiCategory.textContent = `Category: ${category}`;
            bmiCategory.className = `mt-2 text-sm font-semibold ${colorClass}`;
        }
    
        function resetBMI() {
            heightInput.value = "";
            weightInput.value = "";
            bmiOutput.value = "";
            bmiCategory.textContent = "";
        }
    
        heightInput.addEventListener("input", calculateBMI);
        weightInput.addEventListener("input", calculateBMI);
        resetBtn.addEventListener("click", resetBMI);
    });
    </script>
@endsection