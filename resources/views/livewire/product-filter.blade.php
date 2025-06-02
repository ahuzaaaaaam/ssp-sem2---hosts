<div class="space-y-6">
    <!-- Filter and Search Controls -->
    <div class="bg-white rounded-lg shadow-md p-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Category Filter -->
            <div class="flex space-x-2">
                <button wire:click="$set('filter', 'all')"
                    class="px-4 py-2 rounded-full text-sm {{ $filter === 'all' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    All
                </button>
                <button wire:click="$set('filter', 'veg')"
                    class="px-4 py-2 rounded-full text-sm {{ $filter === 'veg' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Vegetarian
                </button>
                <button wire:click="$set('filter', 'non-veg')"
                    class="px-4 py-2 rounded-full text-sm {{ $filter === 'non-veg' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Non-Vegetarian
                </button>
                <button wire:click="$set('filter', 'featured')"
                    class="px-4 py-2 rounded-full text-sm {{ $filter === 'featured' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Featured
                </button>
            </div>
            
            <!-- Search -->
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Search products...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Loading Indicator -->
    <div wire:loading class="w-full flex justify-center">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-600"></div>
    </div>
    
    <!-- Products Grid -->
    <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($products as $product)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->veg === 'Yes' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->veg === 'Yes' ? 'Veg' : 'Non-Veg' }}
                        </span>
                    </div>
                    <p class="text-gray-600 mt-2 text-sm line-clamp-2">{{ $product->description }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-lg font-bold">${{ number_format($product->price, 2) }}</span>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No products found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
            </div>
        @endforelse
    </div>
</div>
