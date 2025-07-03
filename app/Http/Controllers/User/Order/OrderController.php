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

//            $cartItems = CartItem::whereUserId($this->userId)
//                ->with('product', 'color')->get();
//
//
//            foreach ($cartItems as $item) {
//                if ($item->product->status != StatusEnum::ACTIVE ||
//                    $item->product->quantity < $item->quantity)
//                    return $this->sendError("product : {$item->product->name}
//                 is not available");
//            }
//
//            $subTotal = $cartItems->sum(function ($item) {
//                return (int)$item->product->price * $item->quantity;
//            });
//
//            $tax = 0;
//            if (config('taxes.enabled_tax'))
//                $tax = (float)config('taxes.tax_rate');
//
//
//            $data = [
//                'user_id' => $this->userId,
//                'sub_total' => $subTotal,
//                'status' => OrderStatusEnum::PENDING,
//                'tax' => $tax,
//                'total' => self::calculateTax($subTotal)
//            ];
//
//
//            $order = Order::create($data);
//
//
//            $orderProducts = [];
//            foreach ($cartItems as $item) {
//                $orderProducts[] = [
//                    'product_id' => $item->product_id,
//                    'price' => $item->product->price,
//                    'color_id' => $item->color_id,
//                    'quantity' => $item->quantity,
//                    'order_id' => $order->id ,
//                    'created_at' => now() ,
//                    'updated_at' => now()
//                ];
//            }
//
//            OrderProduct::insert($orderProducts);
//
//            CartItem::whereUserId($this->userId)->delete();

           $order = $this->orderService->create($this->userId);

            DB::commit();
            return $this->sendResponce(OrderResource::make($order) ,
                'Order Created successfully');

        }catch (\Exception $exception){
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }


    }
}
