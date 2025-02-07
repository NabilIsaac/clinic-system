<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Drug;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = collect($cart)->sum(function($item) { 
            return $item['price'] * $item['quantity']; 
        });
        return view('shop.cart', compact('cart', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:product,drug',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        $item = $request->type === 'product' 
            ? Product::find($request->id) 
            : Drug::find($request->id);

        if (!$item) {
            return back()->with('error', 'Item not found');
        }

        $cartItem = [
            'id' => $item->id,
            'type' => $request->type,
            'name' => $item->name,
            'description' => $item->description,
            'image_url' => $item->image_url,
            'price' => $item->price,
            'quantity' => $request->quantity
        ];

        $cart[] = $cartItem;
        session()->put('cart', $cart);

        return back()->with('success', 'Item added to cart');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return back()->with('success', 'Item removed from cart');
    }
}