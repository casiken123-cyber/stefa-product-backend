<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // The same product may appear twice, so add up its quantity first
        $wanted = [];
        foreach ($validated['items'] as $item) {
            $wanted[$item['product_id']] = ($wanted[$item['product_id']] ?? 0) + $item['quantity'];
        }

        // If any product is short on stock, nothing is saved
        $order = DB::transaction(function () use ($wanted, $request) {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'total' => 0,
            ]);

            $total = 0;
            foreach ($wanted as $productId => $quantity) {
                $product = OrderStock::take((int) $productId, (int) $quantity);
                $total += $product->price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }

            $order->update(['total' => $total]);
            return $order;
        });

        return new OrderResource($order->load('items.product'));
    }

    public function index(Request $request)
    {
        return OrderResource::collection(
            $request->user()->orders()->with('items.product')->latest()->get()
        );
    }

    public function show(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);
        return new OrderResource($order->load('items.product'));
    }

    // Customers can only cancel their own order, and only before it is delivered.
    // Admins set every other status (so a customer cannot mark an order as delivered).
    public function update(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'status' => 'required|string|in:cancelled',
        ]);

        if (! in_array($order->status, ['pending', 'processing'], true)) {
            return response()->json(['message' => 'This order can no longer be cancelled.'], 422);
        }

        DB::transaction(function () use ($order, $validated) {
            OrderStock::onStatusChange($order, $order->status, $validated['status']);
            $order->update($validated);
        });

        return new OrderResource($order->load('items.product'));
    }

    public function destroy(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);

        DB::transaction(function () use ($order) {
            // An order that was still waiting to be delivered returns its items to stock
            if (in_array($order->status, ['pending', 'processing'], true)) {
                OrderStock::giveBack($order);
            }
            $order->delete();
        });

        return response()->noContent();
    }
}
