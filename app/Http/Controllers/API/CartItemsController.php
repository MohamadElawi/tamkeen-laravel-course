<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\User\Cart\AddProductReqeust;
use App\Http\Requests\User\Cart\UpdateCartItemRequest;
use App\Http\Resources\User\Cart\CartItemResource;
use App\Models\Cart_Item;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartItemsController extends ApiController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //REVIEW - Focus please please
        $userId = auth('user')->id();

        $cart_items = CartItem::whereUserId($userId)
            ->with('product', 'color')->paginate();

        return $this->sendResponce(CartItemResource::collection($cart_items), 'cart_items retrieved successfully'
            , 200, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddProductReqeust $request)
    {

        $product = Product::active()->whereHas('colors', function ($q) use ($request) {
            $q->where('colors.id', $request->color_id);
        })->findOrFail($request->product_id);

        $data = $request->validated();
        $data['user_id'] = auth('user')->id();


        $cart_items = CartItem::create($data);

        // Return JSON response

        return $this->sendResponce($cart_items, 'cart_items created successfully');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, string $id)
    {
        $data = $request->validated();
        $data['user_id'] = auth('user')->id();

        $cartItem = CartItem::where('user_id', $data['user_id'])->findOrFail($id);


        $cartItem->update([
            'quantity' => $request->input('quantity'),
        ]);
        return $this->sendResponce($cartItem, 'cart_items updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $authUserId = auth('user')->id();
        $cart_item = CartItem::where('user_id',$authUserId)->findOrFail($id);
        $cart_item->delete();

        return $this->sendResponce(null, 'The cart_item Is Deleted Successfully');
    }
}
