<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $counts = Product::selectRaw('category, count(*) as total')
            ->whereNotNull('category')
            ->groupBy('category')
            ->pluck('total', 'category');

        $data = Category::orderBy('name')->get()->map(fn ($category) => [
            'id' => $category->id,
            'name' => $category->name,
            'products_count' => (int) ($counts[$category->name] ?? 0),
        ]);

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create($validated);

        return response()->json(['data' => [
            'id' => $category->id,
            'name' => $category->name,
            'products_count' => 0,
        ]], 201);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
        ]);

        // Products keep their category as text, so a rename has to follow them
        DB::transaction(function () use ($category, $validated) {
            Product::where('category', $category->name)->update(['category' => $validated['name']]);
            $category->update($validated);
        });

        return response()->json(['data' => [
            'id' => $category->id,
            'name' => $category->name,
            'products_count' => Product::where('category', $category->name)->count(),
        ]]);
    }

    public function destroy(Category $category)
    {
        if (Product::where('category', $category->name)->exists()) {
            return response()->json([
                'message' => 'This category still has products. Move or delete them first.',
            ], 422);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}
