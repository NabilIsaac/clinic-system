<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bill;
use App\Models\User;
use App\Models\Checkup;
use App\Models\BillItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBillRequest;


class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::latest()
            ->paginate(15);

            $totalBills = $bills->count();
            $pendingAmount = $bills->where('status', 'pending')->sum('total_amount');
            $paidAmount = $bills->where('status', 'paid')->sum('paid_amount');
            $voidedAmount = $bills->where('status', 'voided')->sum('amount');
        
            return view('admin.billing.index', compact(
                'bills',
                'totalBills',
                'pendingAmount',
                'paidAmount',
                'voidedAmount'
            ));
    }

    public function create()
    {
        $patients = User::role('patient')->get();
        return view('admin.billing.create', compact('patients'));
    }

    public function store(StoreBillRequest $request)
    {
        $validatedData = $request->validated();
        
        DB::beginTransaction();
        try {
            // Generate bill number
            $validatedData['bill_number'] = 'BILL-' . strtoupper(Str::random(8));
            $validatedData['bill_date'] = now();
            $validatedData['total_amount'] = $request->total_amount;
            $validatedData['paid_amount'] = 0;
            $validatedData['status'] = 'unpaid';

            $bill = Bill::create($validatedData);

            // Store bill items
            foreach ($request->items as $item) {
                $bill->items()->create([
                    'name' => $item['name'],
                    'type' => $item['type'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['total_price']
                ]);
            }

            DB::commit();

            return redirect()->route('admin.billing.show', $bill)
                ->with('success', 'Bill created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating bill: ' . $e->getMessage());
        }
    }

    public function show(Bill $billing)
    {
        $billing->load(['patient', 'items', 'payments', 'checkup']);
        return view('admin.billing.show', compact('billing'));
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

    public function getPatientItems($patientId)
    {
        $checkups = Checkup::where('patient_id', $patientId)
            ->where('status', 'completed')
            ->with(['medications.drug', 'products.product'])
            ->get();

        $items = [];
        $totalAmount = 0;

        foreach ($checkups as $checkup) {
            foreach ($checkup->medications as $medication) {
                $items[] = [
                    'name' => $medication->drug->name,
                    'type' => 'Medication',
                    'quantity' => $medication->quantity,
                    'unit_price' => $medication->unit_price,
                    'total_price' => $medication->total_price,
                ];
            }

            foreach ($checkup->products as $product) {
                $items[] = [
                    'name' => $product->product->name,
                    'type' => 'Product',
                    'quantity' => $product->quantity,
                    'unit_price' => $product->unit_price,
                    'total_price' => $product->total_price,
                ];
            }

            $totalAmount += $checkup->total_amount;
        }

        return response()->json([
            'items' => $items,
            'total_amount' => $totalAmount
        ]);
    }
}