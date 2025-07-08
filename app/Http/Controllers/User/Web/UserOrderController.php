<?php

namespace App\Http\Controllers\User\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function create(Request $request)
    {
        $userId = Auth::id();
        
        // Check if this is a "Buy Now" request
        if ($request->has('product_id')) {
            $product = \App\Models\Product::active()->findOrFail($request->product_id);
            $quantity = $request->quantity ?? 1;
            $colorId = $request->color_id;
            
            // Validate color if product has colors
            if ($product->colors->count() > 0 && !$colorId) {
                return back()->with('error', 'Please select a color for this product.');
            }
            
            if ($product->colors->count() > 0 && $colorId) {
                $color = $product->colors()->find($colorId);
                if (!$color) {
                    return back()->with('error', 'Please select a valid color for this product.');
                }
            }
            
            // Create a temporary cart item for checkout
            $cartItems = collect([
                (object) [
                    'product' => $product,
                    'quantity' => $quantity,
                    'color' => $colorId ? \App\Models\Color::find($colorId) : null,
                    'is_buy_now' => true
                ]
            ]);
            
            $subTotal = $product->price * $quantity;
            $tax = config('taxes.enabled_tax') ? (float)config('taxes.tax_rate') : 0;
            $total = $subTotal + ($subTotal * $tax / 100);
            
            return view('user.orders.create', compact('cartItems', 'subTotal', 'tax', 'total'));
        }
        
        // Regular cart checkout
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
            
            // Check if this is a "Buy Now" order
            if ($request->has('buy_now_product_id')) {
                $product = \App\Models\Product::active()->findOrFail($request->buy_now_product_id);
                $quantity = $request->buy_now_quantity ?? 1;
                $colorId = $request->buy_now_color_id;
                
                // Create order directly without cart
                $order = $this->orderService->createBuyNowOrder($userId, $product, $quantity, $colorId);
            } else {
                // Regular cart order
                $order = $this->orderService->create($userId);
            }

            return redirect()->route('user.orders.show', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $exception) {
            return back()->with('error', 'Failed to place order: ' . $exception->getMessage());
        }
    }
}
