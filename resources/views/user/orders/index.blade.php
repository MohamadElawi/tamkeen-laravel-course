<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="bg-white dark:bg-gray-800 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 mb-8">
                <div class="p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Order History</h3>
                            <p class="text-gray-600 dark:text-gray-400">Track and manage your purchases</p>
                        </div>
                        <a href="{{ route('user.products.index') }}"
                           class="inline-flex items-center justify-center px-6 py-2 min-w-[140px] bg-emerald-600 hover:bg-emerald-700 text-success font-bold rounded-lg shadow transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Orders List -->
            <div class="space-y-6">
                @if($orders->count() > 0)
                    @foreach($orders as $order)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="p-6">
                                @include('components.flash-messages')
                                <div class="flex flex-col lg:flex-row justify-between items-start gap-6">
                                    <!-- Order Info -->
                                    <div class="flex-1">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">
                                                            Order #{{ $order->order_number }}
                                                        </h4>
                                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            {{ $order->created_at->format('M d, Y \a\t g:i A') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <!-- Status Badge -->
                                                <div class="mb-4">
                                                    @switch($order->status->value)
                                                        @case('pending')
                                                        <span class="inline-flex items-center justify-center px-4 py-2 min-w-[120px] rounded-full text-sm font-bold bg-amber-500 text-white shadow border-2 border-amber-400 hover hover:bg-black">
                                                                <div class="w-2 h-2 hover:bg-black rounded-full mr-2 animate-pulse"></div>
                                                                Pending Review
                                                            </span>
                                                        @break
                                                        @case('accepted')
                                                        <span class="inline-flex items-center justify-center px-4 py-2 min-w-[120px] rounded-full text-sm font-bold bg-green-600 text-white shadow border-2 border-green-500 hover:bg-black">
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                                Accepted
                                                            </span>
                                                        @break
                                                        @case('rejected')
                                                        <span class="inline-flex items-center justify-center px-4 py-2 min-w-[120px] rounded-full text-sm font-bold bg-red-600 text-white shadow border-2 border-red-500 hover:bg-black-500">
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                                Rejected
                                                            </span>
                                                        @break
                                                        @default
                                                        <span class="inline-flex items-center justify-center px-4 py-2 min-w-[120px] rounded-full text-sm font-bold bg-gray-600 text-white shadow border-2 border-gray-500 hover
                                                                {{ ucfirst($order->status->value) }}
                                                            </span>
                                                    @endswitch
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Order Items Summary -->
                                        <div class="mb-4">
                                            <div class="flex items-center gap-2 mb-3">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                <span class="inline-flex items-center px-3 py-1 min-w-[120px] bg-gray-100 dark:bg-gray-700 text-blue-700 dark:text-blue-300 font-bold rounded shadow">
                                                    {{ $order->orderProducts->count() }} item(s) in this order
                                                </span>
                                            </div>
                                            <div class="flex flex-wrap gap-3">
                                                @foreach($order->orderProducts->take(4) as $orderProduct)
                                                    <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 rounded-xl px-3 py-2 border border-gray-200 dark:border-gray-600">
                                                        @if($orderProduct->product->getFirstMediaUrl('main-image'))
                                                            <img src="{{ $orderProduct->product->getFirstMediaUrl('main-image') }}"
                                                                 alt="{{ $orderProduct->product->name }}"
                                                                 class="w-8 h-8 object-cover rounded-lg border-2 border-white dark:border-gray-600 shadow-sm">
                                                        @else
                                                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <div class="flex flex-col">
                                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                                                {{ Str::limit($orderProduct->product->name, 20) }}
                                                            </span>
                                                            <span class="text-xs text-gray-600 dark:text-gray-300">
                                                                Qty: {{ $orderProduct->quantity }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if($order->orderProducts->count() > 4)
                                                    <div class="flex items-center gap-2 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-bold rounded-xl px-3 py-2 border border-blue-300 dark:border-blue-700">
                                                        <span class="text-sm">
                                                            +{{ $order->orderProducts->count() - 4 }} more
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Order Total -->
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                <span class="inline-flex items-center px-3 py-1 min-w-[120px] bg-gray-100 dark:bg-gray-700 text-green-700 dark:text-green-300 font-bold rounded shadow text-lg">
                                                    Total: ${{ number_format($order->total, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="flex flex-col gap-3">
                                        <a href="{{ route('user.orders.show', $order->id) }}"
                                           class="inline-flex items-center justify-center px-6 py-2 min-w-[120px] bg-blue-600 hover:bg-blue-700 text-gray-500 font-bold rounded-lg shadow transition-all duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                <!-- Pagination -->
                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $orders   ->links() }}
                        </div>
                @else
                <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50">
                        <div class="p-12 text-center">
                            <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">No Orders Yet</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-8 max-w-md mx-auto">
                                You haven't placed any orders yet. Start shopping to see your order history here.
                            </p>
                            <a href="{{ route('user.products.index') }}"
                               class="inline-flex items-center justify-center px-8 py-3 min-w-[140px] bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg shadow transition-all duration-200">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Start Shopping
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
