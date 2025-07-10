<?php

namespace App\Http\Controllers\User\Web;

use App\Http\Controllers\Controller;
use App\Enums\StatusEnum;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class UserCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', StatusEnum::ACTIVE)
            ->whereHas('products', function ($q) {
                $q->where('status', StatusEnum::ACTIVE);
            })
            ->withCount(['products' => function ($q) {
                $q->where('status', StatusEnum::ACTIVE);
            }])
            ->with(['media'])
            ->get();

        return view('user.categories.index', compact('categories'));
    }

    public function show($id, Request $request)
    {
        // Verify the category exists and is active
        $category = Category::where('status', StatusEnum::ACTIVE)
            ->findOrFail($id);

        // Redirect to products index with category filter
        return redirect()->route('user.products.index', [
            'category_id' => $id,
            'search' => $request->input('search'),
            'color_id' => $request->input('color_id'),
            'price_from' => $request->input('price_from'),
            'price_to' => $request->input('price_to')
        ]);
    }
} 