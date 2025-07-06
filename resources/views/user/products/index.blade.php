<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Browse Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filters Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('user.products.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                <select name="category_id" id="category_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Color Filter -->
                            <div>
                                <label for="color_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                                <select name="color_id" id="color_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">All Colors</option>
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}" {{ request('color_id') == $color->id ? 'selected' : '' }}>
                                            {{ $color->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price Range -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label for="price_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Min Price</label>
                                    <input type="number" name="price_from" id="price_from" value="{{ request('price_from') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="price_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max Price</label>
                                    <input type="number" name="price_to" id="price_to" value="{{ request('price_to') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-gray-800 font-bold py-2 px-4 rounded">
                                Apply Filters
                            </button>
                            <a href="{{ route('user.products.index') }}" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @include('components.flash-messages')
                    <div class="flex justify-end mb-6">
                        <a href="{{ route('user.orders.create') }}"
                           class="inline-flex items-center px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-gray-500 font-bold rounded-lg shadow transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M9 3v18m6-18v18" />
                            </svg>
                            Go to Checkout
                        </a>
                    </div>
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($products as $product)
                                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                    <!-- Product Image -->
                                    <div class="aspect-w-1 aspect-h-1 w-full">
                                        @if($product->getFirstMediaUrl('main-image'))
                                            <img src="{{ $product->getFirstMediaUrl('main-image') }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                <span class="text-gray-500 dark:text-gray-400">No Image</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                            {{ $product->name }}
                                        </h3>

                                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-2">
                                            {{ Str::limit($product->description, 100) }}
                                        </p>

                                        <!-- Categories -->
                                        @if($product->categories->count() > 0)
                                            <div class="mb-3">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($product->categories->take(2) as $category)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-gray-500-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                            {{ $category->name }}
                                                        </span>
                                                    @endforeach
                                                    @if($product->categories->count() > 2)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                            +{{ $product->categories->count() - 2 }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Colors -->
                                        @if($product->colors->count() > 0)
                                            <div class="mb-3">
                                                <div class="flex flex-wrap gap-1 text-gray-500">
                                                    @foreach($product->colors->take(3) as $color)
                                                        <div class="w-6 h-6 rounded-full border-2 border-gray-300 text-gray-500"
                                                             style="background-color: {{ $color->hex_code ?? '#gray' }}"
                                                             title="{{ $color->title }}"></div>
                                                    @endforeach
                                                    @if($product->colors->count() > 3)
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">+{{ $product->colors->count() - 3 }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Price and Action -->
                                        <div class="flex justify-between items-center">
                                            <span class="text-xl font-bold text-gray-900 dark:text-white">
                                                ${{ number_format($product->price, 2) }}
                                            </span>
                                            <a href="{{ route('user.products.show', $product->id) }}"
                                               class="bg-indigo-600 hover:bg-indigo-700 text-gray-500 text-sm font-medium py-2 px-4 rounded">
                                                View Details
                                            </a>
                                        </div>

                                        <!-- Add to Cart Form -->
                                        @if($product->quantity > 0)
                                            <form method="POST" action="{{ route('user.cart-items.store') }}" class="mt-3">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                @if($product->colors->count() > 0)
                                                    <label for="color_id_{{ $product->id }}" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Color</label>
                                                    <select name="color_id" id="color_id_{{ $product->id }}" required
                                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white mb-2">
                                                        <option value="">Select color</option>
                                                        @foreach($product->colors as $color)
                                                            <option value="{{ $color->id }}">{{ $color->title }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                                <button type="submit"
                                                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-gray-500 font-bold py-2 px-4 rounded mt-1 transition-colors duration-200">
                                                    Add to Cart
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Stock Status -->
                                        @if($product->quantity > 0)
                                            <div class="mt-2">
                                                <span class="text-sm text-green-600 dark:text-green-400">
                                                    In Stock ({{ $product->quantity }})
                                                </span>
                                            </div>
                                        @else
                                            <div class="mt-2">
                                                <span class="text-sm text-red-600 dark:text-red-400">
                                                    Out of Stock
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-500 dark:text-gray-400 text-lg mb-4">
                                No products found matching your criteria.
                            </div>
                            <a href="{{ route('user.products.index') }}"
                               class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Browse All Products
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
