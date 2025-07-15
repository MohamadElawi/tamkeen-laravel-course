<?php

namespace App\Http\Controllers\User\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserOrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of user orders
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $orders = Order::whereUserId($userId)
            ->with(['orderProducts.product', 'orderProducts.color'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    /**
     * Display the specified order
     */
    public function show($id)
    {
        $userId = Auth::id();
        $order = Order::whereUserId($userId)
            ->with(['orderProducts.product', 'orderProducts.color', 'user'])
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }

    /**
     * Show the form for creating a new order (checkout)
     */
    public function create()
    {
        $userId = Auth::id();
        $cartItems = \App\Models\CartItem::whereUserId($userId)
            ->with(['product', 'color'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.products.index')
                ->with('error', 'Your cart is empty. Please add some products before checkout.');
        }

        // Calculate totals
        $subTotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $tax = config('taxes.enabled_tax') ? (float)config('taxes.tax_rate') : 0;
        $total = $subTotal + ($subTotal * $tax / 100);

        return view('user.orders.create', compact('cartItems', 'subTotal', 'tax', 'total'));
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request)
    {
        try {
            $userId = Auth::id();
            $order = $this->orderService->create($userId);
            Log::driver('order')->info('Order Created' ,['order_id' => $order->id , 'user_id' => $userId]);
            return redirect()->route('user.orders.show', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Failed to place order: ' . $exception->getMessage());
        }
    }
}
