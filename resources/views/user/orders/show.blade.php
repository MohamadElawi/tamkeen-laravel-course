<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Order Header -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Order #{{ $order->order_number }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}
                            </p>
                        </div>
                        <div class="text-right">
                            @switch($order->status->value)
                                @case('pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        Pending
                                    </span>
                                    @break
                                @case('accepted')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Accepted
                                    </span>
                                    @break
                                @case('rejected')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        Rejected
                                    </span>
                                    @break
                                @default
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        {{ ucfirst($order->status->value) }}
                                    </span>
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Items</h4>

                            <div class="space-y-4">
                                @foreach($order->orderProducts as $orderProduct)
                                    <div class="flex items-center space-x-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @if($orderProduct->product->getFirstMediaUrl('main-image'))
                                                <img src="{{ $orderProduct->product->getFirstMediaUrl('main-image') }}"
                                                     alt="{{ $orderProduct->product->name }}"
                                                     class="w-16 h-16 object-cover rounded">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                                    <span class="text-gray-500 dark:text-gray-400 text-xs">No Image</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1">
                                            <h5 class="font-semibold text-gray-900 dark:text-white">
                                                {{ $orderProduct->product->name }}
                                            </h5>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Quantity: {{ $orderProduct->quantity }}
                                            </p>
                                            @if($orderProduct->color)
                                                <div class="flex items-center space-x-2 mt-1">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">Color:</span>
                                                    <div class="w-4 h-4 rounded-full border border-gray-300"
                                                         style="background-color: {{ $orderProduct->color->hex_code ?? '#gray' }}"
                                                         title="{{ $orderProduct->color->name }}"></div>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $orderProduct->color->name }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Price -->
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900 dark:text-white">
                                                ${{ number_format($orderProduct->price * $orderProduct->quantity, 2) }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                ${{ number_format($orderProduct->price, 2) }} each
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
                                        ${{ number_format($order->sub_total, 2) }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        ${{ number_format($order->tax, 2) }}
                                    </span>
                                </div>

                                <hr class="border-gray-200 dark:border-gray-700">

                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-gray-900 dark:text-white">Total:</span>
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                                        ${{ number_format($order->total, 2) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 space-y-3">
                                <a href="{{ route('user.orders.index') }}"
                                   class="w-full bg-gray-600 hover:bg-gray-700 text-gray-500 font-bold py-2 px-4 rounded text-center block">
                                    Back to Orders
                                </a>
                                <a href="{{ route('user.products.index') }}"
                                   class="w-full bg-blue-600 hover:bg-gray-700 text-gray-500 font-bold py-2 px-4 rounded text-center block">
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
