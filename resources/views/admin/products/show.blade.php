<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Product Details') }}
            </h2>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.products.edit', $product) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-150">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Edit Product') }}
                </a>
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-150">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Products') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Product Information Card -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Product ID: #{{ $product->id }}</p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">${{ number_format($product->price, 2) }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                            <dd class="mt-1">
                                @if($product->status === \App\Enums\StatusEnum::ACTIVE)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        <svg class="w-1.5 h-1.5 mr-2 fill-current" viewBox="0 0 6 6">
                                            <circle cx="3" cy="3" r="3"/>
                                        </svg>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                        <svg class="w-1.5 h-1.5 mr-2 fill-current" viewBox="0 0 6 6">
                                            <circle cx="3" cy="3" r="3"/>
                                        </svg>
                                        Inactive
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono bg-gray-50 dark:bg-gray-700 px-2 py-1 rounded">{{ $product->slug }}</dd>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Categories</dt>
                            <dd class="mt-2">
                                @forelse($product->categories as $category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 mr-2 mb-2">
                                        {{ $category->name }}
                                    </span>
                                @empty
                                    <span class="text-sm text-gray-500 dark:text-gray-400">No categories assigned</span>
                                @endforelse
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Colors</dt>
                            <dd class="mt-2">
                                @forelse($product->colors as $color)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 mr-2 mb-2">
                                        <div class="w-2 h-2 rounded-full mr-1.5" style="background-color: {{ $color->hex_code ?? '#gray' }}"></div>
                                        {{ $color->name }}
                                    </span>
                                @empty
                                    <span class="text-sm text-gray-500 dark:text-gray-400">No colors assigned</span>
                                @endforelse
                            </dd>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $product->created_at->format('M d, Y') }}
                                <span class="text-gray-500 dark:text-gray-400">at {{ $product->created_at->format('g:i A') }}</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $product->updated_at->format('M d, Y') }}
                                <span class="text-gray-500 dark:text-gray-400">at {{ $product->updated_at->format('g:i A') }}</span>
                            </dd>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($product->description)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Description</dt>
                        <dd class="text-sm text-gray-900 dark:text-gray-100 leading-relaxed">{{ $product->description }}</dd>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Quick Actions</h4>
                    <div class="flex items-center space-x-3">
                        <!-- Status Toggle -->
                        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 border border-amber-300 text-amber-700 dark:text-amber-400 rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/20 focus:outline-none focus:ring-2 focus:ring-amber-500 transition-colors duration-150">
                                @if($product->status === \App\Enums\StatusEnum::ACTIVE)
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                    </svg>
                                    Deactivate
                                @else
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Activate
                                @endif
                            </button>
                        </form>

                        <!-- Delete -->
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" 
                              onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 border border-red-300 text-red-700 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors duration-150">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>