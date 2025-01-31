<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Drug;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        
        // Get all items (both drugs and products)
        $query = match($type) {
            'medicines' => Drug::query()->with('category'),
            'products' => Product::query()->with('category'),
            default => null
        };

        if ($query === null) {
            // For 'all' type, merge both drugs and products
            $drugs = Drug::with('category')->get();
            $products = Product::with('category')->get();
            
            // Merge collections and sort by name
            $allItems = $drugs->concat($products)->sortBy('name');
            
            // Manual pagination
            $offset = ($page - 1) * $perPage;
            $items = new LengthAwarePaginator(
                $allItems->slice($offset, $perPage),
                $allItems->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $items = $query->paginate($perPage);
        }

        // Calculate statistics
        $totalItems = Drug::count() + Product::count();
        $lowStockItems = Drug::where('stock_quantity', '<=', \DB::raw('reorder_level'))->count() +
                        Product::where('stock_quantity', '<=', \DB::raw('reorder_level'))->count();
        $outOfStockItems = Drug::where('stock_quantity', 0)->count() +
                          Product::where('stock_quantity', 0)->count();
        $totalValue = Drug::sum(\DB::raw('stock_quantity * price')) +
                     Product::sum(\DB::raw('stock_quantity * price'));

        return view('admin.inventory.index', compact(
            'items',
            'totalItems',
            'lowStockItems',
            'outOfStockItems',
            'totalValue',
            'type'
        ));
    }

    public function create()
    {
        // Get drug and product categories separately
        $drugCategories = Category::where('type', 'drug')->get();
        $productCategories = Category::where('type', 'product')->get();
        
        return view('admin.inventory.create', compact('drugCategories', 'productCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'reorder_level' => 'required|integer|min:0',
            'sku' => 'required|string|unique:drugs,sku|unique:products,sku',
            'type' => 'required|in:drug,product',
            'generic_name' => 'required_if:type,drug|nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($validated['type'] === 'drug') {
            $item = Drug::create($validated);
        } else {
            $item = Product::create($validated);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $item->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Item added successfully.');
    }

    public function edit($id, Request $request)
    {
        $type = $request->get('type');
        $item = $type === 'drug' ? Drug::findOrFail($id) : Product::findOrFail($id);
        $categories = Category::where('type', $type)->get();

        return view('admin.inventory.edit', compact('item', 'categories', 'type'));
    }

    public function update($id, Request $request)
    {
        $type = $request->get('type');
        $item = $type === 'drug' ? Drug::findOrFail($id) : Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'reorder_level' => 'required|integer|min:0',
            'sku' => 'required|string|unique:drugs,sku,' . $id . '|unique:products,sku,' . $id,
            'generic_name' => $type === 'drug' ? 'required|string' : 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        $item->update($validated);

        // Handle image upload
        if ($request->hasFile('image')) {
            $item->clearMediaCollection('image');
            $item->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy($id, Request $request)
    {
        $type = $request->get('type');
        $item = $type === 'drug' ? Drug::findOrFail($id) : Product::findOrFail($id);
        
        // Delete associated media
        $item->clearMediaCollection('image');
        $item->delete();

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Item deleted successfully.');
    }

    public function export()
    {
        $drugs = Drug::with('category')->get();
        $products = Product::with('category')->get();

        // Here you would implement the export logic
        // For example, creating a CSV or Excel file

        return response()->download('path_to_generated_file');
    }

    public function adjustStock($id, Request $request)
    {
        $type = $request->get('type');
        $item = $type === 'drug' ? Drug::findOrFail($id) : Product::findOrFail($id);
        
        $validated = $request->validate([
            'adjustment' => 'required|integer',
            'reason' => 'required|string'
        ]);

        $item->stock_quantity += $validated['adjustment'];
        $item->save();

        // You might want to log this adjustment in a separate table
        // StockAdjustment::create([...])

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Stock adjusted successfully.');
    }
}
