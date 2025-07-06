<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\OrderStatusEnum;
use App\Events\OrderCompleted;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\Order\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
//    protected $orderService ;
    public function __construct(protected OrderService $orderService)
    {
//        $this->orderService = $this->orderService ;
    }

    public function index(Request $request){
         $orders = $this->orderService->getAll($request->count);
        return $this->sendResponce(OrderResource::collection($orders) ,
            'Orders retrieved successfully',
            200,
            true);
    }

    public function show($id){
        $order = $this->orderService->getById($id);
        return $this->sendResponce(OrderResource::make($order) ,
            'Orders retrieved successfully');
    }

    public function accept($id){
        $order = $this->orderService->getById($id);

        if($order->status != OrderStatusEnum::PENDING)
            $this->sendError('the Order status should be pending');

        $order->update([
            'status' => OrderStatusEnum::ACCEPTED
        ]);

//        event(new OrderCompleted($order));
        return $this->sendResponce(OrderResource::make($order) ,'Order accepted successfully');
    }

    public function rejedct($id){
        $order = $this->orderService->getById($id);

        if($order->status != OrderStatusEnum::PENDING)
            $this->sendError('the Order status should be pending');

        $order->update([
            'status' => OrderStatusEnum::REJECTED
        ]);


        return $this->sendResponce(OrderResource::make($order) ,'Order accepted successfully');
    }

}
