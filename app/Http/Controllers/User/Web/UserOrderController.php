<?php

namespace App\Http\Controllers\User\Web;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
            $userId = auth()->id();
            DB::beginTransaction();
            $sessionUrl = $this->orderService->create($userId);

            DB::commit();
            return redirect()->away($sessionUrl);

//            return redirect()->route('user.orders.show', $order->id)
//                ->with('success', 'Order placed successfully!');

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();
            return back()->with('error', 'Failed to place order: ' . $exception->getMessage());
        }
    }

    public function success(Request $request){
        $sessionId = $request->query('session_id');

        // Retrieve the Stripe session
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        // Verify payment status
        if ($session->payment_status === 'paid') {
            $order =Order::find($request->order_id);
            $order->update(['status' => OrderStatusEnum::ACCEPTED]);
            return redirect()->route('user.orders.show', $order->id)
                ->with('success', 'Order placed successfully!');
        }

        throw new \Exception('Payment not completed');
    }

    public function cancel(Request $request){
        return redirect()->route('user.orders.index')
            ->with('error', 'payment failed!');
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = env('STRIPE_WEBHOOK_SECRET'); // Set in .env

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Webhook signature verification failed'], 400);
        }


        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            if ($session->payment_status === 'paid') {
                //
            }
        }

        return response()->json(['status' => 'success']);
    }
}
