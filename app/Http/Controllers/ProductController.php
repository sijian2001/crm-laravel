<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');

        $products = Product::query()
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $categories = Product::distinct()->pluck('category')->filter();

        return view('products.index', compact('products', 'search', 'category', 'categories'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|max:255|unique:products,sku',
            'category' => 'required|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'status' => 'boolean',
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'sku' => $request->sku,
            'category' => $request->category,
            'stock_quantity' => $request->stock_quantity,
            'image_url' => $request->image_url,
            'status' => $request->has('status'),
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', '製品が正常に登録されました。');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'category' => 'required|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'status' => 'boolean',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'sku' => $request->sku,
            'category' => $request->category,
            'stock_quantity' => $request->stock_quantity,
            'image_url' => $request->image_url,
            'status' => $request->has('status'),
        ]);

        return redirect()
            ->route('products.show', $product)
            ->with('success', '製品情報が正常に更新されました。');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', '製品が正常に削除されました。');
    }
}
