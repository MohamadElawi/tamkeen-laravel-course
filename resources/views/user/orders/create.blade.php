<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="flex justify-end">
        @if(session('error'))
            <div class="alert alert-danger text-red-600">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Review Your Order</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Please review your cart items before placing your order.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Cart Items</h4>

                            <div class="space-y-4">
                                @foreach($cartItems as $cartItem)
                                    <div class="flex items-center space-x-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/50 shadow-sm">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0 w-20 h-20 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg flex items-center justify-center overflow-hidden shadow">
                                            @if($cartItem->product->getFirstMediaUrl('main-image'))
                                                <img src="{{ $cartItem->product->getFirstMediaUrl('main-image') }}"
                                                     alt="{{ $cartItem->product->name }}"
                                                     class="object-cover w-full h-full">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <span class="text-gray-500 dark:text-gray-400 text-xs">No Image</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1 px-3 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-inner">
                                            <h5 class="font-semibold text-gray-900 dark:text-white mb-1">
                                                {{ $cartItem->product->name }}
                                            </h5>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                                Quantity: {{ $cartItem->quantity }}
                                            </p>
                                            @if($cartItem->color)
                                                <div class="flex items-center space-x-2 mt-1">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">Color:</span>
                                                    <div class="w-4 h-4 rounded-full border border-gray-300"
                                                         style="background-color: {{ $cartItem->color->hex_code ?? '#343434' }}"
                                                         title="{{ $cartItem->color->title }}"></div>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $cartItem->color->title }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Price -->
                                        <div class="text-right min-w-[90px]">
                                            <p class="font-semibold text-green-700 dark:text-green-400">
                                                ${{ number_format($cartItem->product->price * $cartItem->quantity, 2) }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                ${{ number_format($cartItem->product->price, 2) }} each
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Summary</h4>

                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        ${{ number_format($subTotal, 2) }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Tax ({{ $tax }}%):</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        ${{ number_format($subTotal * $tax / 100, 2) }}
                                    </span>
                                </div>

                                <hr class="border-gray-200 dark:border-gray-700">

                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-gray-900 dark:text-white">Total:</span>
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                                        ${{ number_format($total, 2) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <form method="POST" action="{{ route('user.orders.store') }}" class="mt-6">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-green-600 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded text-center block">
                                    Place Order
                                </button>
                            </form>

                            <!-- Action Buttons -->
                            <div class="mt-4 space-y-3">
                                <a href="{{ route('user.products.index') }}"
                                   class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center block">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
