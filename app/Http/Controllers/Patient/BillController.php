<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BillController extends Controller
{
    public function index()
    {
        $bills = auth()->user()->bills()
            ->with(['items', 'payments'])
            ->latest()
            ->paginate(10);

        return view('patient.bills.index', compact('bills'));
    }

    public function show(Bill $bill)
    {
        if ($bill->patient_id !== auth()->id()) {
            abort(403);
        }

        $bill->load(['items', 'payments', 'checkup']);
        return view('patient.bills.show', compact('bill'));
    }

    public function pay(Request $request, Bill $bill)
    {
        if ($bill->patient_id !== auth()->id() || $bill->status === 'paid') {
            abort(403);
        }

        $request->validate([
            'amount' => ['required', 'numeric', 'min:1', "max:{$bill->remaining_amount}"],
            'payment_method' => ['required', 'in:cash,card']
        ]);

        // Create payment record
        $payment = $bill->payments()->create([
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'completed'
        ]);

        // Update bill
        $bill->paid_amount += $request->amount;
        $bill->status = $bill->paid_amount >= $bill->total_amount ? 'paid' : 'partial';
        $bill->save();

        return redirect()->route('patient.bills.show', $bill)
            ->with('success', 'Payment processed successfully.');
    }

    public function download(Bill $bill)
    {
        if ($bill->patient_id !== auth()->id()) {
            abort(403);
        }

        $pdf = PDF::loadView('patient.bills.pdf', compact('bill'));
        
        // Set paper size to A4
        $pdf->setPaper('a4');
        
        // Optional: Set other PDF options
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif'
        ]);

        return $pdf->download("bill-{$bill->bill_number}.pdf");
    }
}