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
                    @if(session('error') || session('success'))
                        <div class="mb-4">
                            @if(session('error'))
                                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative dark:bg-red-900/30 dark:border-red-800 dark:text-red-400" role="alert">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-medium">{{ session('error') }}</span>
                                    </div>
                                </div>
                            @endif
                            @if(session('success'))
                                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative dark:bg-green-900/30 dark:border-green-800 dark:text-green-400" role="alert">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-medium">{{ session('success') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
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
                                                         title="{{ $orderProduct->color->title }}"></div>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $orderProduct->color->title }}
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
                                   class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center block">
                                    Back to Orders
                                </a>
                                <a href="{{ route('user.products.index') }}"
                                   class="w-full bg-blue-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center block">
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
