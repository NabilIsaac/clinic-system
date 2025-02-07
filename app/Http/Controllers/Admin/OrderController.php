<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user']);

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date Range Filter
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('receptionist.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items']);
        return view('receptionist.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,delivered,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Order status updated successfully');
    }
}