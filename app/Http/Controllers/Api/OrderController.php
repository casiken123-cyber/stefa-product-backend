<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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

        $order = DB::transaction(function () use ($validated, $request) {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'total' => 0,
            ]);

            $total = 0;
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $lineTotal = $product->price * $item['quantity'];
                $total += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
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

    public function update(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
            'admin_id' => 'sometimes|exists:admins,id',
        ]);

        $order->update($validated);

        return new OrderResource($order->load('items.product'));
    }

    public function destroy(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);

        $order->delete();

        return response()->noContent();
    }
}