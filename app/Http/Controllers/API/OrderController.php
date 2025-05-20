<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {


        $total = 0;
        $quantity = 0;
        $productsData = $request->input('products');


        foreach ($productsData as $item) {

            $product = Product::find($item['id']);


            $price = $product->getRawOriginal('price');
            $productQuantity = $item['quantity'];

            $total += $price * $productQuantity;


            $quantity += $productQuantity;
        }


        $tax = $total * 0.15;

        $order = Order::create([
            'total' => $total,
            'tax' => $tax,
            'quantity' => $quantity,
        ]);


        foreach ($productsData as $item) {
            $order->Orderproducts()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);
        }


        return $this->sendResponce(
            new OrderResource($order->load('Orderproducts')),
            __('Order_stored_successfully'),
            201
        );


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
