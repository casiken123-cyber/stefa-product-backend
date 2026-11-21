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
    // Orders only move forward. Delivered and cancelled orders are final.
    private const NEXT_STATUS = [
        'pending' => ['processing', 'completed', 'cancelled'],
        'processing' => ['completed', 'cancelled'],
        'completed' => [],
        'cancelled' => [],
    ];

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

        DB::transaction(function () use ($order, $validated, $request) {
            // Lock the order row and read its status inside the lock, so a customer
            // cancelling at the same moment cannot return the items to stock twice
            $locked = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            $previous = $locked->status;

            if ($previous !== $validated['status']
                && ! in_array($validated['status'], self::NEXT_STATUS[$previous] ?? [], true)) {
                $message = match ($previous) {
                    'cancelled' => 'A cancelled order is locked and its status cannot be changed.',
                    'completed' => 'A delivered order is locked and its status cannot be changed.',
                    default => "An order that is {$previous} cannot go back to {$validated['status']}.",
                };

                abort(422, $message);
            }

            // Cancelling returns the items to stock; re-opening a cancelled order takes them out again
            OrderStock::onStatusChange($locked, $previous, $validated['status']);

            $locked->update([
                'status' => $validated['status'],
                'admin_id' => $request->user()->id,
            ]);

            // Tell the customer when the delivery status really changed
            if ($previous !== $validated['status']) {
                Notice::create([
                    'user_id' => $locked->user_id,
                    'order_id' => $locked->id,
                    'message' => $this->statusMessage($locked, $validated['status']),
                ]);
            }
        });

        return response()->json([
            'data' => $this->format($order->refresh()->load(['user:id,name,email', 'items.product'])),
        ]);
    }

    // Delete an order. Only cancelled orders can be deleted: cancelling already
    // returned the items to stock, so deleting does not touch the stock again.
    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            $locked = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();

            if ($locked->status !== 'cancelled') {
                abort(422, 'Only cancelled orders can be deleted. Cancel the order first.');
            }

            Notice::where('order_id', $locked->id)->delete();
            $locked->items()->delete();
            $locked->delete();
        });

        return response()->json(['message' => 'Order deleted.']);
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
            // Where to deliver the order (null on orders placed before shipping details were saved)
            'shipping' => [
                'name' => $order->shipping_name,
                'phone' => $order->shipping_phone,
                'address' => $order->shipping_address,
                'city' => $order->shipping_city,
                'zip' => $order->shipping_zip,
                'payment_method' => $order->payment_method,
            ],
            'items' => $order->items->map(fn ($item) => [
                'product_id' => $item->product_id,
                'name' => optional($item->product)->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ])->values(),
        ];
    }
}