@extends('layouts.app')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Confirmation Modal -->
        <div id="confirmationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Payslip Generation</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500" id="modalSummary"></p>
                    </div>
                    <div class="flex justify-end mt-4 space-x-3">
                        <button id="cancelConfirmation" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                            Cancel
                        </button>
                        <button id="confirmGeneration" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Generate Payslips</h2>
                    <a href="{{ route('admin.payslips.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                        Cancel
                    </a>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form id="payslipForm" action="{{ route('admin.payslips.bulk-store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Period Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Period Start</label>
                            <input type="date" name="period_start" required value="{{ old('period_start') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('period_start') border-red-500 @enderror">
                            @error('period_start')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Period End</label>
                            <input type="date" name="period_end" required value="{{ old('period_end') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('period_end') border-red-500 @enderror">
                            @error('period_end')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Salary Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Selected Employees</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Salary</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Daily Rate</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($employees as $emp)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" name="employee_ids[]" value="{{ $emp->id }}" class="employee-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $emp->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $emp->department->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($emp->salary, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($emp->salary / 22, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Work Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Days Present</label>
                            <input type="number" name="days_present" required value="{{ old('days_present', 22) }}" min="0" max="31"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Total Working Days</label>
                            <input type="number" name="total_working_days" required value="{{ old('total_working_days', 22) }}" min="0" max="31"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Overtime Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Overtime Hours</label>
                            <input type="number" step="0.5" name="overtime_hours" value="{{ old('overtime_hours', 0) }}" min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Overtime Rate (x)</label>
                            <input type="number" step="0.1" name="overtime_rate" value="{{ old('overtime_rate', 1.5) }}" min="1"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Allowances & Deductions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Allowances</label>
                            <input type="number" step="0.01" name="allowances" value="{{ old('allowances', 0) }}" min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deductions</label>
                            <input type="number" step="0.01" name="deductions" value="{{ old('deductions', 0) }}" min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Live Preview Section -->
                    <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Preview</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Base Pay</p>
                                <p class="text-lg font-medium" id="previewBasePay">$0.00</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Overtime Pay</p>
                                <p class="text-lg font-medium" id="previewOvertimePay">$0.00</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Allowances</p>
                                <p class="text-lg font-medium text-green-600" id="previewAllowances">$0.00</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Deductions</p>
                                <p class="text-lg font-medium text-red-600" id="previewDeductions">$0.00</p>
                            </div>
                            <div class="col-span-2 border-t pt-4 mt-4">
                                <p class="text-sm font-medium text-gray-600">Estimated Net Pay</p>
                                <p class="text-2xl font-bold text-blue-600" id="previewNetPay">$0.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('admin.payslips.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                            Cancel
                        </a>
                        <button type="button" id="showConfirmation"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Generate Payslip
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const employeeCheckboxes = document.querySelectorAll('.employee-checkbox');
    const form = document.getElementById('payslipForm');

    // Checkbox handling
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            employeeCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            calculateTotalPayroll(); // Recalculate when selection changes
        });
    }

    employeeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const totalCheckboxes = employeeCheckboxes.length;
            const checkedCheckboxes = document.querySelectorAll('.employee-checkbox:checked').length;
            
            selectAllCheckbox.checked = totalCheckboxes === checkedCheckboxes;
            selectAllCheckbox.indeterminate = checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
            calculateTotalPayroll(); // Recalculate when selection changes
        });
    });

    // Salary data
    const baseSalaries = {
        @foreach($employees as $emp)
            {{ $emp->id }}: {{ $emp->salary }},
        @endforeach
    };
    const dailyRates = {
        @foreach($employees as $emp)
            {{ $emp->id }}: {{ $emp->salary / 22 }},
        @endforeach
    };

    // Input elements
    const inputs = {
        daysPresent: form.querySelector('[name="days_present"]'),
        totalDays: form.querySelector('[name="total_working_days"]'),
        overtimeHours: form.querySelector('[name="overtime_hours"]'),
        overtimeRate: form.querySelector('[name="overtime_rate"]'),
        allowances: form.querySelector('[name="allowances"]'),
        deductions: form.querySelector('[name="deductions"]')
    };

    // Preview elements
    const preview = {
        basePay: document.getElementById('previewBasePay'),
        overtimePay: document.getElementById('previewOvertimePay'),
        allowances: document.getElementById('previewAllowances'),
        deductions: document.getElementById('previewDeductions'),
        netPay: document.getElementById('previewNetPay')
    };

    function calculateTotalPayroll() {
        const selectedEmployees = Array.from(document.querySelectorAll('.employee-checkbox:checked'))
            .map(checkbox => checkbox.value);

        const daysPresent = parseFloat(inputs.daysPresent.value) || 0;
        const totalDays = parseFloat(inputs.totalDays.value) || 22;
        const overtimeHours = parseFloat(inputs.overtimeHours.value) || 0;
        const overtimeRate = parseFloat(inputs.overtimeRate.value) || 1.5;
        const allowances = parseFloat(inputs.allowances.value) || 0;
        const deductions = parseFloat(inputs.deductions.value) || 0;

        let totalBasePay = 0;
        let totalOvertimePay = 0;
        let totalAllowances = 0;
        let totalDeductions = 0;

        selectedEmployees.forEach(empId => {
            const baseSalary = baseSalaries[empId];
            const dailyRate = dailyRates[empId];

            totalBasePay += (daysPresent / totalDays) * baseSalary;
            totalOvertimePay += (dailyRate / 8) * overtimeHours * overtimeRate;
            totalAllowances += allowances;
            totalDeductions += deductions;
        });

        const totalNetPay = totalBasePay + totalOvertimePay + totalAllowances - totalDeductions;

        // Update preview
        preview.basePay.textContent = `$${totalBasePay.toFixed(2)}`;
        preview.overtimePay.textContent = `$${totalOvertimePay.toFixed(2)}`;
        preview.allowances.textContent = `$${totalAllowances.toFixed(2)}`;
        preview.deductions.textContent = `$${totalDeductions.toFixed(2)}`;
        preview.netPay.textContent = `$${totalNetPay.toFixed(2)}`;

        return {
            totalBasePay,
            totalOvertimePay,
            totalAllowances,
            totalDeductions,
            totalNetPay,
            selectedEmployees
        };
    }

    // Add input event listeners
    Object.values(inputs).forEach(input => {
        input.addEventListener('input', calculateTotalPayroll);
    });

    // Modal handling
    const modal = document.getElementById('confirmationModal');
    const confirmBtn = document.getElementById('confirmGeneration');
    const cancelBtn = document.getElementById('cancelConfirmation');
    const showModalBtn = document.getElementById('showConfirmation');
    const modalSummary = document.getElementById('modalSummary');

    showModalBtn.addEventListener('click', function() {
        const calculations = calculateTotalPayroll();
        if (calculations.selectedEmployees.length === 0) {
            alert('Please select at least one employee');
            return;
        }
        
        modalSummary.innerHTML = `
            <div class="text-left">
                <p class="mb-2">Selected Employees: ${calculations.selectedEmployees.length}</p>
                <p class="mb-2">Period: ${form.period_start.value} to ${form.period_end.value}</p>
                <p class="mb-2">Total Base Pay: $${calculations.totalBasePay.toFixed(2)}</p>
                <p class="mb-2">Total Overtime Pay: $${calculations.totalOvertimePay.toFixed(2)}</p>
                <p class="mb-2">Total Allowances: $${calculations.totalAllowances.toFixed(2)}</p>
                <p class="mb-2">Total Deductions: $${calculations.totalDeductions.toFixed(2)}</p>
                <p class="font-bold">Total Net Pay: $${calculations.totalNetPay.toFixed(2)}</p>
            </div>
        `;
        modal.classList.remove('hidden');
    });

    cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));
    confirmBtn.addEventListener('click', () => form.submit());

    // Form validation
    form.addEventListener('submit', function(e) {
        const selectedEmployees = document.querySelectorAll('.employee-checkbox:checked');
        if (selectedEmployees.length === 0) {
            e.preventDefault();
            alert('Please select at least one employee');
            return;
        }

        const startDate = new Date(form.period_start.value);
        const endDate = new Date(form.period_end.value);
        
        if (endDate < startDate) {
            e.preventDefault();
            alert('Period end date cannot be earlier than start date');
        }
    });

    // Initial calculation
    calculateTotalPayroll();
});
</script>
@endpush
@endsection