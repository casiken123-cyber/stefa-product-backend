<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        return OrderItemResource::collection(OrderItem::with(['order', 'product'])->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $orderItem = OrderItem::create($data);

        return (new OrderItemResource($orderItem->load(['order', 'product'])))
            ->response()
            ->setStatusCode(201);
    }

    public function show(OrderItem $orderItem)
    {
        return new OrderItemResource($orderItem->load(['order', 'product']));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $data = $request->validate([
            'quantity' => 'sometimes|integer|min:1',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $orderItem->update($data);

        return new OrderItemResource($orderItem->load(['order', 'product']));
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return response()->noContent();
    }
}