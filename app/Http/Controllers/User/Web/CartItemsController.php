<?php

namespace App\Http\Controllers\User\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Cart\AddProductReqeust;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemsController extends Controller
{
    /**
     * Store a newly created cart item in storage.
     */
    public function store(AddProductReqeust $request)
    {
        $userId = Auth::id();

        // Check product exists and is active
        $product = Product::active()->findOrFail($request->product_id);

        // If product has colors, check color_id is valid for this product
        if ($product->colors->count() > 0) {
            if (!$request->color_id || !$product->colors->pluck('id')->contains($request->color_id)) {
                return back()->with('error', 'Please select a valid color.');
            }
        }

        // Add to cart
        $cartItem = CartItem::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $product->id,
                'color_id' => $request->color_id,
            ],
            [
                'quantity' => $request->quantity,
            ]
        );

        return back()->with('success', 'Product added to cart!');
    }
} 