<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return ProductResource::collection($query->paginate(15));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['admin_id'] = $request->user()->id; // the logged-in admin

        if ($request->hasFile('image')) {
            $validated['image_url'] = '/storage/' . $request->file('image')->store('products', 'public');
        }

        unset($validated['image']);

        $product = Product::create($validated);

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'admin_id' => 'sometimes|exists:admins,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = $this->uniqueSlug($validated['name'], $product->id);
        }

        if ($request->hasFile('image')) {
            $this->deleteLocalImage($product->image_url);
            $validated['image_url'] = '/storage/' . $request->file('image')->store('products', 'public');
        }

        unset($validated['image']);

        $product->update($validated);

        return new ProductResource($product);
    }

    // A product that appears in any order cannot be deleted, so old orders and the
    // sales history keep their items. Set its stock to 0 to stop selling it instead.
    public function destroy(Product $product)
    {
        $imageUrl = DB::transaction(function () use ($product) {
            // Lock the product row, so an order being placed at this moment
            // cannot slip in between the check and the delete
            $locked = Product::whereKey($product->id)->lockForUpdate()->firstOrFail();

            if ($locked->orderItems()->exists()) {
                abort(422, 'This product is part of existing orders and cannot be deleted. Set its stock to 0 to stop selling it.');
            }

            $locked->delete();

            return $locked->image_url;
        });

        // Only remove the picture once the product is really gone
        $this->deleteLocalImage($imageUrl);

        return response()->json(['message' => 'Product deleted']);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $original = Str::slug($name);
        $slug = $original;
        $count = 2;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }

    private function deleteLocalImage(?string $imageUrl): void
    {
        if ($imageUrl && str_starts_with($imageUrl, '/storage/')) {
            Storage::disk('public')->delete(Str::after($imageUrl, '/storage/'));
        }
    }
}