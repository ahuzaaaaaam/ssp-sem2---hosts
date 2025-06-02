<div>
    {{-- Be like water. --}}
    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Search Input -->
            <div class="flex-grow">
                <input wire:model.live="search" type="text" placeholder="Search for products..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-red-500 focus:border-red-500">
            </div>
            
            <!-- Dietary Filter -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <input wire:model.live="dietaryFilter" type="radio" id="all" value="all"
                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                    <label for="all" class="ml-2 block text-sm font-medium text-gray-700">All</label>
                </div>
                <div class="flex items-center">
                    <input wire:model.live="dietaryFilter" type="radio" id="veg" value="veg"
                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                    <label for="veg" class="ml-2 block text-sm font-medium text-gray-700">Vegetarian</label>
                </div>
                <div class="flex items-center">
                    <input wire:model.live="dietaryFilter" type="radio" id="nonveg" value="nonveg"
                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                    <label for="nonveg" class="ml-2 block text-sm font-medium text-gray-700">Non-Vegetarian</label>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Loading Indicator -->
    <div wire:loading class="w-full text-center py-4">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-red-600"></div>
        <p class="mt-2 text-gray-600">Loading products...</p>
    </div>
    
    <!-- Products Grid -->
    <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mx-auto max-w-6xl">
        @forelse ($products as $product)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-sm">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold">{{ $product->name }}</h3>
                        <span class="text-lg font-bold">${{ number_format($product->price, 2) }}</span>
                    </div>
                    <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                    
                    <div class="flex items-center justify-between">
                        @if($product->veg === 'Yes')
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Vegetarian</span>
                        @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Non-Vegetarian</span>
                        @endif
                        
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 text-sm">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No products found</h3>
                <p class="mt-1 text-gray-500">Try adjusting your search or filter criteria.</p>
                <button wire:click="resetFilters" class="mt-4 text-red-600 hover:text-red-800 font-medium">Clear all filters</button>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
