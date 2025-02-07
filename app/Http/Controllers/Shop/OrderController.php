<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $subtotal = collect($cart)->sum(function($item) { 
            return $item['price'] * $item['quantity']; 
        });
        return view('shop.checkout', compact('cart', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string',
            'phone' => 'required|string',
        ]);
    
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty');
        }
    
        try {
            return DB::transaction(function () use ($request, $cart) {
                $subtotal = collect($cart)->sum(function($item) { 
                    return $item['price'] * $item['quantity']; 
                });
                
                $reference = "Ref_" . Str::random(10);
                
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'total_amount' => $subtotal,
                    'shipping_address' => $request->delivery_address,
                    'phone' => $request->phone,
                    'payment_reference' => $request->reference,
                    'payment_status' => 'paid',
                    'status' => 'processing',
                    'reference' => $reference
                ]);
            
                foreach($cart as $item) {
                    $order->items()->create([
                        'product_id' => $item['id'],
                        'product_type' => $item['type'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ]);
                }
            
                // Clear the cart
                session()->forget('cart');
            
                return redirect()->route('shop.orders.show', $order)
                    ->with('success', 'Order placed successfully!');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to process your order. Please try again.');
        }
    }

    public function show(Order $order)
    {
        return view('shop.orders.show', compact('order'));
    }

    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('shop.orders.index', compact('orders'));
    }
}