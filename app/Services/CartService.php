<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Exceptions\InvalidCartItemsException;
use App\Models\CartItem;

class CartService
{
    public function getUserCartItems($userId){
        return  CartItem::whereUserId($userId)
            ->with('product', 'color')->get();
    }


    public function validateCartItems($cartItems){
        foreach ($cartItems as $item) {
            if ($item->product->status != StatusEnum::ACTIVE ||
                $item->product->quantity < $item->quantity)
//                throw new \Exception("product : {$item->product->name}
//                 is not available");
                throw new InvalidCartItemsException("product : {$item->product->name}
//                 is not available");
        }
    }

    public function removeUserCart($userId){
        CartItem::whereUserId($userId)->delete();
    }
}
