
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your PDF styling here */
    </style>
</head>
<body>
    <div class="payslip">
        <h1>Payslip</h1>
        <div class="employee-info">
            <p>Employee: {{ $employee->name }}</p>
            <p>Period: {{ $payslip->period_start->format('d/m/Y') }} - {{ $payslip->period_end->format('d/m/Y') }}</p>
        </div>
        
        <div class="salary-details">
            <table>
                <tr>
                    <td>Basic Salary</td>
                    <td>{{ number_format($payslip->basic_salary, 2) }}</td>
                </tr>
                <tr>
                    <td>Allowances</td>
                    <td>{{ number_format($payslip->allowances, 2) }}</td>
                </tr>
                <tr>
                    <td>Deductions</td>
                    <td>{{ number_format($payslip->deductions, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Net Salary</strong></td>
                    <td><strong>{{ number_format($payslip->net_salary, 2) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>