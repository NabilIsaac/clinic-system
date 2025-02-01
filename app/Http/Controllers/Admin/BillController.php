<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with(['patient', 'items', 'payments'])
            ->latest()
            ->paginate(15);

        return view('admin.billing.index', compact('bills'));
    }

    public function create()
    {
        $patients = User::role('patient')->get();
        return view('admin.billing.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'due_date' => 'required|date|after:today',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.amount' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        $totalAmount = collect($request->items)->sum(function ($item) {
            return $item['amount'] * $item['quantity'];
        });

        $bill = Bill::create([
            'patient_id' => $request->patient_id,
            'bill_number' => 'BILL-' . strtoupper(Str::random(8)),
            'total_amount' => $totalAmount,
            'paid_amount' => 0,
            'status' => 'unpaid',
            'due_date' => $request->due_date,
            'notes' => $request->notes
        ]);

        foreach ($request->items as $item) {
            $bill->items()->create([
                'description' => $item['description'],
                'amount' => $item['amount'],
                'quantity' => $item['quantity']
            ]);
        }

        return redirect()->route('admin.billing.show', $bill)
            ->with('success', 'Bill created successfully.');
    }

    public function show(Bill $bill)
    {
        $bill->load(['patient', 'items', 'payments', 'checkup']);
        return view('admin.billing.show', compact('bill'));
    }

    public function edit(Bill $bill)
    {
        if ($bill->status === 'paid') {
            return redirect()->route('admin.billing.show', $bill)
                ->with('error', 'Paid bills cannot be edited.');
        }

        $patients = User::role('patient')->get();
        return view('admin.billing.edit', compact('bill', 'patients'));
    }

    public function update(Request $request, Bill $bill)
    {
        if ($bill->status === 'paid') {
            return redirect()->route('admin.bills.show', $bill)
                ->with('error', 'Paid bills cannot be updated.');
        }

        $request->validate([
            'due_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.amount' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        $totalAmount = collect($request->items)->sum(function ($item) {
            return $item['amount'] * $item['quantity'];
        });

        $bill->update([
            'total_amount' => $totalAmount,
            'due_date' => $request->due_date,
            'notes' => $request->notes
        ]);

        // Delete existing items and create new ones
        $bill->items()->delete();
        foreach ($request->items as $item) {
            $bill->items()->create([
                'description' => $item['description'],
                'amount' => $item['amount'],
                'quantity' => $item['quantity']
            ]);
        }

        return redirect()->route('admin.billing.show', $bill)
            ->with('success', 'Bill updated successfully.');
    }

    public function destroy(Bill $bill)
    {
        if ($bill->status === 'paid') {
            return redirect()->route('admin.billing.show', $bill)
                ->with('error', 'Paid bills cannot be deleted.');
        }

        $bill->delete();
        return redirect()->route('admin.billing.index')
            ->with('success', 'Bill deleted successfully.');
    }
}