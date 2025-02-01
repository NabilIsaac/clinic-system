<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['bill.patient'])
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function create(Bill $bill)
    {
        if ($bill->status === 'paid') {
            return redirect()->route('admin.bills.show', $bill)
                ->with('error', 'This bill is already paid in full.');
        }

        return view('admin.payments.create', compact('bill'));
    }

    public function store(Request $request, Bill $bill)
    {
        if ($bill->status === 'paid') {
            return redirect()->route('admin.bills.show', $bill)
                ->with('error', 'This bill is already paid in full.');
        }

        $request->validate([
            'amount' => ['required', 'numeric', 'min:1', "max:{$bill->remaining_amount}"],
            'payment_method' => ['required', 'in:cash,card,bank_transfer,insurance'],
            'transaction_id' => ['nullable', 'string'],
            'notes' => ['nullable', 'string']
        ]);

        $payment = $bill->payments()->create([
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => 'completed',
            'notes' => $request->notes
        ]);

        // Update bill
        $bill->paid_amount += $request->amount;
        $bill->status = $bill->paid_amount >= $bill->total_amount ? 'paid' : 'partial';
        $bill->save();

        return redirect()->route('admin.bills.show', $bill)
            ->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['bill.patient']);
        return view('admin.payments.show', compact('payment'));
    }

    public function void(Payment $payment)
    {
        if ($payment->status !== 'completed') {
            return redirect()->route('admin.payments.show', $payment)
                ->with('error', 'Only completed payments can be voided.');
        }

        // Update payment status
        $payment->update(['status' => 'voided']);

        // Update bill
        $bill = $payment->bill;
        $bill->paid_amount -= $payment->amount;
        $bill->status = $bill->paid_amount <= 0 ? 'unpaid' : 'partial';
        $bill->save();

        return redirect()->route('admin.payments.show', $payment)
            ->with('success', 'Payment voided successfully.');
    }

    public function report(Request $request)
    {
        $query = Payment::with(['bill.patient'])
            ->where('status', 'completed');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $payments = $query->latest()->get();
        $totalAmount = $payments->sum('amount');

        return view('admin.payments.report', compact('payments', 'totalAmount'));
    }
}