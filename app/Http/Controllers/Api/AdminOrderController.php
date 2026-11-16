<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user:id,name,email', 'items.product'])->latest()->get();

        return response()->json([
            'data' => $orders->map(fn ($order) => $this->format($order)),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
        ]);

        $order->update([
            'status' => $validated['status'],
            'admin_id' => $request->user()->id,
        ]);

        return response()->json([
            'data' => $this->format($order->load(['user:id,name,email', 'items.product'])),
        ]);
    }

    public function stats()
    {
        return response()->json([
            'sales' => (float) Order::where('status', '!=', 'cancelled')->sum('total'),
            'users' => User::count(),
            'orders' => Order::count(),
            'products' => Product::count(),
            'low_stock' => Product::where('stock', '<=', 5)->count(),
        ]);
    }

    private function format(Order $order): array
    {
        return [
            'id' => $order->id,
            'status' => $order->status,
            'total' => $order->total,
            'created_at' => $order->created_at,
            'customer' => $order->user ? [
                'id' => $order->user->id,
                'name' => $order->user->name,
                'email' => $order->user->email,
            ] : null,
            'items' => $order->items->map(fn ($item) => [
                'product_id' => $item->product_id,
                'name' => optional($item->product)->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ])->values(),
        ];
    }
}