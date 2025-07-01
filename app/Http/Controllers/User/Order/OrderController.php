<?php

namespace App\Http\Controllers\User\Order;

use App\Enums\OrderStatusEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Traits\TaxCalculatorTrait;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    use TaxCalculatorTrait;

    public function index()
    {

    }

    public function show()
    {

    }

    // checkout
    public function store(OrderRequest $request)
    {
        $userId = auth('user')->id();

        $cartItems = CartItem::whereUserId($userId)
            ->with('product', 'color')->get();


        foreach ($cartItems as $item) {
            if ($item->product->status != StatusEnum::ACTIVE ||
                $item->product->quantity < $item->quantity)
                $this->sendError("product : {$item->product->name}
                 is not available");
        }

        $subTotal = $cartItems->sum(function ($item) {
            return (int)$item->product->price * $item->quantity;
        });

        $tax = 0;
        if(config('taxes.enabled_tax'))
            $tax = (float)config('tax_rate');


        $data = [
            'user_id' => $userId,
            'sub_total' => $subTotal,
            'status' => OrderStatusEnum::PENDING,
            'tax' => $tax ,
            'total' => self::calculateTax($subTotal)
        ];


        $order = Order::create($data);

    }
}
