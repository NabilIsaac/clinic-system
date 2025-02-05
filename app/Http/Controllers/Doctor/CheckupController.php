<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Checkup;
use App\Models\User;
use App\Models\Drug;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CheckupRequest;

class CheckupController extends Controller
{
    public function index()
    {
        $checkups = Checkup::with(['patient', 'doctor'])
        ->filter(request(['search', 'status', 'date_from', 'date_to']))
        ->where('doctor_id', auth()->id())
        ->latest()
        ->paginate(10);
        $statuses = Checkup::getStatuses();
        return view('doctor.checkups.index', [
            'checkups' => $checkups,
            'statuses' => $statuses
        ]);
    }

    public function create()
    {
        $patients = User::role('patient')->get();
        $drugs = Drug::all();
        $products = Product::all();
        return view('doctor.checkups.create', [
            'patients' => $patients,
            'drugs' => $drugs,
            'products' => $products
        ]);
    }

    public function store(CheckupRequest $request)
    {
        // dd($request->all());
        $validated = $request->validated();
        
        // Initialize totals
        $medicationsTotal = 0;
        $productsTotal = 0;
        
        // Calculate medications total
        if (!empty($validated['medications'])) {
            foreach ($validated['medications'] as $medicine) {
                $drug = Drug::find($medicine['drug_id']);
                $medicationsTotal += $drug->price * $medicine['quantity'];
            }
        }
        
        // Calculate products total
        if (!empty($validated['products'])) {
            foreach ($validated['products'] as $product) {
                $prod = Product::find($product['product_id']);
                $productsTotal += $prod->price * $product['quantity'];
            }
        }
        
        // Calculate grand total
        $grandTotal = $medicationsTotal + $productsTotal;

        $checkup = Checkup::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => auth()->id(),
            'reason' => $validated['reason'],
            'bp' => $validated['bp'],
            'visit_history' => $validated['visit_history'],
            'additional_comments' => $validated['additional_comments'] ?? null,
            'total_amount' => $grandTotal,
            'status' => 'completed'
        ]);

        // Save medications with their prices
        if (!empty($validated['medications'])) {
            foreach ($validated['medications'] as $medicine) {
                $drug = Drug::find($medicine['drug_id']);
                $checkup->medications()->create([
                    'drug_id' => $medicine['drug_id'],
                    'quantity' => $medicine['quantity'],
                    'dosage' => $medicine['dosage'],
                    'unit_price' => $drug->price,
                    'total_price' => $drug->price * $medicine['quantity']
                ]);
            }
        }

        // Save products with their prices
        if (!empty($validated['products'])) {
            foreach ($validated['products'] as $product) {
                $prod = Product::find($product['product_id']);
                $checkup->products()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'unit_price' => $prod->price,
                    'total_price' => $prod->price * $product['quantity']
                ]);
            }
        }

        return redirect()->route('doctor.checkups.show', $checkup)
        ->with('success', 'Checkup created successfully.');
        // return response()->json([
        //     'message' => 'Checkup created successfully',
        //     'checkup' => $checkup->load('medications', 'products', 'patient')
        // ]);
    }

    public function show(Checkup $checkup)
    {
        $checkup->load(['patient', 'medications', 'products']);
        return view('doctor.checkups.show', compact('checkup'));
    }

    public function update(Request $request, Checkup $checkup)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in-progress,completed,cancelled',
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $checkup->update($validated);

        return response()->json([
            'message' => 'Checkup updated successfully',
            'checkup' => $checkup->fresh()
        ]);
    }

    public function destroy(Checkup $checkup)
    {
        // Delete related medications and products first
        $checkup->medications()->delete();
        $checkup->products()->delete();

        // Delete the checkup
        $checkup->delete();

        return redirect()->route('doctor.checkups.index')
            ->with('success', 'Checkup deleted successfully.');
    }

    public function getPatients(Request $request)
    {
        $search = $request->get('search');
        
        $patients = User::role('patient')
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->take(5)
            ->get(['id', 'name', 'email']);

        return response()->json($patients);
    }
}