<?php

namespace App\Http\Controllers\User\Order;

use App\Enums\OrderStatusEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\User\Order\OrderResource;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\OrderService;
use App\Traits\TaxCalculatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends ApiController
{
    use TaxCalculatorTrait;

    protected $userId ;
    protected $orderService ;

    public function __construct(OrderService $orderService)
    {
        $this->userId =  auth('user')->id();
        $this->orderService = $orderService ;
    }


    public function index(Request $request)
    {
        $orders = Order::whereUserId($this->userId)->paginate($request->count);
        return $this->sendResponce(OrderResource::collection($orders) ,
            'Orders retrieved successfully',
            200,
            true);
    }

    public function show($id)
    {
        $order = Order::whereUserId($this->userId)->findOrFail($id);

        return $this->sendResponce(OrderResource::make($order) ,
            'Orders retrieved successfully');

    }

    // checkout
    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();
           $order = $this->orderService->create($this->userId);

            DB::commit();
            Log::driver('order')->info('Order Created' ,['order_id' => $order->id , 'user_id' => $this->userId]);
            return $this->sendResponce(OrderResource::make($order) ,
                'Order Created successfully');

        }catch (\Exception $exception){
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->sendError($exception->getMessage());
        }

    }
}
