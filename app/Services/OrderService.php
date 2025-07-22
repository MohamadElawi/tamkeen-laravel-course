<?php

namespace App\Services;

use App\Enums\Media\ProductMediaEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Traits\TaxCalculatorTrait;
use Illuminate\Support\Facades\Cache;

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



        $order = $this->saveOrder($userId ,$subTotal ,$tax );

        $this->saveOrderProducts($order ,$cartItems);
        $session = $this->createSession($cartItems ,$order);

        $this->cartService->removeUserCart($userId);

//        return $order ;
        return $session->url;
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


    public function saveOrder($userId ,$subTotal, $tax ){
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


    public function createSession($cartItems ,$order){
        \Stripe\Stripe::setApiKey(config('stripe.secret_key'));

        $lineItems = [];

        foreach ($cartItems as $cartItem) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd' ,
                    'product_data' => [
                        'name' => $cartItem->product->name,
                    ],
                    'unit_amount' => $cartItem->product->price * 100
                ],
                'quantity' => $cartItem->quantity
            ];

        }

        // Create Stripe Checkout Session
        return \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') ."?session_id={CHECKOUT_SESSION_ID}&order_id={$order->id}",
            // localhost:8000/user/orders/checkout/
            'cancel_url' => route('checkout.cancel'),
        ]);
    }

}
