<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bill #{{ $bill->bill_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .clinic-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .bill-info {
            margin-bottom: 20px;
        }
        .bill-info table {
            width: 100%;
        }
        .bill-info td {
            padding: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f8f9fa;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .totals table {
            width: 100%;
        }
        .totals td {
            padding: 5px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .status {
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
            font-size: 12px;
        }
        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-partially_paid {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-unpaid {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>MEDICAL BILL</h1>
    </div>

    <div class="clinic-info">
        <h2>{{ config('app.name') }}</h2>
        <p>123 Medical Center Drive<br>
        Los Angeles, CA 90001<br>
        Phone: (555) 123-4567<br>
        Email: billing@clinic.com</p>
    </div>

    <div class="bill-info">
        <table>
            <tr>
                <td><strong>Bill #:</strong></td>
                <td>{{ $bill->bill_number }}</td>
                <td><strong>Date:</strong></td>
                <td>{{ $bill->created_at->format('M d, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Patient:</strong></td>
                <td>{{ $bill->patient->name }}</td>
                <td><strong>Due Date:</strong></td>
                <td>{{ $bill->due_date->format('M d, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td colspan="3">
                    <span class="status status-{{ $bill->status }}">
                        {{ str_replace('_', ' ', ucfirst($bill->status)) }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->items as $item)
            <tr>
                <td>
                    {{ $item->description }}
                    @if($item->billable)
                    <br>
                    <small>{{ class_basename($item->billable_type) }} #{{ $item->billable_id }}</small>
                    @endif
                </td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->amount, 2) }}</td>
                <td>${{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td>${{ number_format($bill->total_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Paid Amount:</strong></td>
                <td>${{ number_format($bill->paid_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Balance Due:</strong></td>
                <td>${{ number_format($bill->remaining_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    <div class="footer">
        <p>Thank you for choosing {{ config('app.name') }}.<br>
        For any billing inquiries, please contact our billing department at (555) 123-4567 or billing@clinic.com</p>
        
        @if($bill->notes)
        <p><strong>Notes:</strong><br>{{ $bill->notes }}</p>
        @endif
    </div>
</body>
</html>