<?php

namespace App\Http\Controllers\User\Web;

use App\Http\Controllers\Controller;
use App\Enums\StatusEnum;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    public function index(Request $request)
    {
        // $query = Product::query()
        //     ->active()
        //     ->with(['categories', 'colors', 'media']);

        // // Search functionality
        // if ($request->filled('search')) {
        //     $search = $request->input('search');
        //     $query->where(function($q) use($search) {
        //         $q->where('name->en', 'like', "%$search%")
        //           ->orWhere('name->ar', 'like', "%$search%");
        //     });
        // }



        // // Color filter
        // if ($request->filled('color_id')) {
        //     $query->whereHas('colors', function($q) use($request) {
        //         $q->where('colors.id', $request->color_id)
        //           ->where('status', StatusEnum::ACTIVE);
        //     });
        // }

        // // Price filter
        // if ($request->filled('price_from')) {
        //     $query->where('price', '>=', $request->price_from);
        // }

        // if ($request->filled('price_to')) {
        //     $query->where('price', '<=', $request->price_to);
        // }

        $query = Product::query()
        //            ->withoutGlobalScope(ActiveScope::class)
                    ->active()
                    ->search($request->input('search'))
                    ->colorFilter($request->input('color_id'))
                    ->CategoryFilter($request->input('category_id'))
                    ->priceFilter($request->input('price_from'),$request->input('price_to'));

        $products = $query->paginate(12);

        // Get categories and colors for filters
        $categories = Category::where('status', StatusEnum::ACTIVE)->get();
        $colors = Color::where('status', StatusEnum::ACTIVE)->get();

        return view('user.products.index', compact('products', 'categories', 'colors'));
    }

    public function show($id)
    {
        $product = Product::active()
            ->with(['categories', 'colors' => function($q) {
                $q->where('status', StatusEnum::ACTIVE);
            }, 'media'])
            ->findOrFail($id);

        return view('user.products.show', compact('product'));
    }
}
