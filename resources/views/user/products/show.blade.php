<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $product->name }}
            </h2>
            <a href="{{ route('user.products.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Product Images -->
                        <div class="space-y-4">
                            <!-- Main Image -->
                            <div class="aspect-w-1 aspect-h-1 w-full">
                                @if($product->getFirstMediaUrl('main-image'))
                                    <img src="{{ $product->getFirstMediaUrl('main-image') }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-96 object-cover rounded-lg">
                                @else
                                    <div class="w-full h-96 bg-gray-200 dark:bg-gray-600 flex items-center justify-center rounded-lg">
                                        <span class="text-gray-500 dark:text-gray-400 text-lg">No Image Available</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Gallery Images -->
                            @if($product->getMedia('gallery')->count() > 0)
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach($product->getMedia('gallery')->take(4) as $media)
                                        <img src="{{ $media->getUrl() }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75 transition-opacity">
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="space-y-6">
                            <!-- Product Name and Price -->
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                    {{ $product->name }}
                                </h1>
                                <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                                    ${{ number_format($product->price, 2) }}
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Description</h3>
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                            </div>

                            <!-- Stock Status -->
                            <div>
                                @if($product->quantity > 0)
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        <span class="text-green-600 dark:text-green-400 font-medium">
                                            In Stock ({{ $product->quantity }} available)
                                        </span>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                        <span class="text-red-600 dark:text-red-400 font-medium">
                                            Out of Stock
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Categories -->
                            @if($product->categories->count() > 0)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Categories</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($product->categories as $category)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Colors -->
                            @if($product->colors->count() > 0)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Available Colors</h3>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($product->colors as $color)
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 rounded-full border-2 border-gray-300" 
                                                     style="background-color: {{ $color->hex_code ?? '#gray' }}"></div>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $color->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Product Actions -->
                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    @if($product->quantity > 0)
                                        <button class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                                            Add to Cart
                                        </button>
                                        <button class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                                            Buy Now
                                        </button>
                                    @else
                                        <button disabled class="flex-1 bg-gray-400 text-white font-bold py-3 px-6 rounded-lg cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Product ID:</span>
                                        <span class="text-gray-900 dark:text-white ml-2">#{{ $product->id }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                        <span class="text-gray-900 dark:text-white ml-2">{{ $product->status->translate() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 