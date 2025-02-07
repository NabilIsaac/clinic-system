<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Drug;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')->paginate(12);
        $drugs = Drug::where('status', 'active')
            ->where('requires_prescription', false)
            ->paginate(12);

        return view('shop.index', compact('products', 'drugs'));
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('shop.product', compact('product'));
    }

    public function showDrug($id)
    {
        $drug = Drug::findOrFail($id);
        return view('shop.drug', compact('drug'));
    }
}