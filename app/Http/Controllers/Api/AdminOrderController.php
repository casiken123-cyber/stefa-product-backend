<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $previous = $order->status;

        // Cancelling returns the items to stock; re-opening a cancelled order takes them out again
        DB::transaction(function () use ($order, $previous, $validated, $request) {
            OrderStock::onStatusChange($order, $previous, $validated['status']);

            $order->update([
                'status' => $validated['status'],
                'admin_id' => $request->user()->id,
            ]);
        });

        // Tell the customer when the delivery status really changed
        if ($previous !== $validated['status']) {
            Notice::create([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'message' => $this->statusMessage($order, $validated['status']),
            ]);
        }

        return response()->json([
            'data' => $this->format($order->load(['user:id,name,email', 'items.product'])),
        ]);
    }

    // Send the customer a custom delivery update about this order
    public function notify(Request $request, Order $order)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:500',
        ]);

        Notice::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'message' => $validated['message'],
        ]);

        return response()->json(['message' => 'Notification sent to the customer.'], 201);
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

    private function statusMessage(Order $order, string $status): string
    {
        $label = '#STF-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);

        return match ($status) {
            'processing' => "Your order {$label} is being prepared for delivery.",
            'completed' => "Your order {$label} has been delivered. You can now review the products.",
            'cancelled' => "Your order {$label} was cancelled.",
            default => "Your order {$label} is now {$status}.",
        };
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
