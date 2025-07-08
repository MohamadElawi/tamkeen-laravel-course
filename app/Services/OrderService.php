<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Traits\TaxCalculatorTrait;

class OrderService
{
    use TaxCalculatorTrait;
    protected $cartService ;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }


    public function getAll($count , $userId = null){
        return $orders = Order::when($userId ,function ($q) use($userId){
            $q->whereUserId($userId);
        })->paginate($count);
    }

    public function getById($id , $userId = null){
        return Order::when($userId ,function($q) use($userId){
          $q->whereUserId($userId);
        })->findOrFail($id);
    }

    public function create($userId){
        $cartItems = $this->cartService->getUserCartItems($userId);

        $this->cartService->validateCartItems($cartItems);

        $subTotal = $this->calculateSubTotal($cartItems);

        $tax = $this->calculateTaxRate();

        $order = $this->saveOrder($userId ,$subTotal ,$tax);

        $this->saveOrderProducts($order ,$cartItems);

        $this->cartService->removeUserCart($userId);

        return $order ;
    }

    public function createBuyNowOrder($userId, $product, $quantity, $colorId = null){
        // Validate product availability
        if ($product->quantity < $quantity) {
            throw new \Exception('Insufficient product quantity available.');
        }

        $subTotal = $product->price * $quantity;
        $tax = $this->calculateTaxRate();

        $order = $this->saveOrder($userId, $subTotal, $tax);

        // Create order product directly
        OrderProduct::create([
            'product_id' => $product->id,
            'price' => $product->price,
            'color_id' => $colorId,
            'quantity' => $quantity,
            'order_id' => $order->id,
        ]);

        return $order;
    }


    public function calculateSubTotal($cartItems){
        return  $cartItems->sum(function ($item) {
            return (int)$item->product->price * $item->quantity;
        });
    }

    public function calculateTaxRate(){
//        $tax = 0;
//        if (config('taxes.enabled_tax'))
//            $tax = (float)config('taxes.tax_rate');

        return config('taxes.enabled_tax') ? (float)config('taxes.tax_rate') : 0 ;
    }


    public function saveOrder($userId ,$subTotal, $tax){
        return Order::create([
            'user_id' => $userId,
            'sub_total' => $subTotal,
            'status' => OrderStatusEnum::PENDING,
            'tax' => $tax,
            'total' => self::calculateTax($subTotal)
        ]);
    }

    public function saveOrderProducts($order ,$cartItems){
        $orderProducts = [];
        foreach ($cartItems as $item) {
            $orderProducts[] = [
                'product_id' => $item->product_id,
                'price' => $item->product->price,
                'color_id' => $item->color_id,
                'quantity' => $item->quantity,
                'order_id' => $order->id ,
                'created_at' => now() ,
                'updated_at' => now()
            ];
        }

        OrderProduct::insert($orderProducts);
    }


}
