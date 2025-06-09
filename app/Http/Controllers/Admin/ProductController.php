<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['categories', 'colors']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }
        
        $products = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $colors = Color::all();
        return view('admin.products.create', compact('categories', 'colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'categories' => ['array'],
            'colors' => ['array'],
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
            'status' => StatusEnum::ACTIVE
        ]);

        if ($request->filled('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->filled('colors')) {
            $product->colors()->sync($request->colors);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        $product->load(['categories', 'colors']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $colors = Color::all();
        $product->load(['categories', 'colors']);
        return view('admin.products.edit', compact('product', 'categories', 'colors'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'categories' => ['array'],
            'colors' => ['array'],
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
        ]);

        $product->categories()->sync($request->categories ?? []);
        $product->colors()->sync($request->colors ?? []);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function toggleStatus(Product $product)
    {
        $product->status = $product->status === StatusEnum::ACTIVE ? StatusEnum::INACTIVE : StatusEnum::ACTIVE;
        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product status updated successfully');
    }
} 