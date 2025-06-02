<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/2">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-md">
                        </div>
                        <div class="md:w-1/2 md:pl-8 mt-4 md:mt-0">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                            
                            <div class="flex items-center mt-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $product->veg == 'Yes' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->veg == 'Yes' ? 'Vegetarian' : 'Non-Vegetarian' }}
                                </span>
                                @if($product->featured == 'Yes')
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Featured</span>
                                @endif
                            </div>
                            
                            <div class="mt-4">
                                <span class="text-2xl font-bold text-gray-900">₹{{ number_format($product->price, 2) }}</span>
                            </div>
                            
                            <div class="mt-4 text-gray-700">
                                <p>{{ $product->description }}</p>
                            </div>
                            
                            <div class="mt-6">
                                <form action="{{ route('products.addToCart', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="flex items-center">
                                        <label for="quantity" class="mr-3 text-sm font-medium text-gray-700">Quantity:</label>
                                        <select id="quantity" name="quantity" class="block w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @for($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <button type="submit" data-product-id="{{ $product->id }}" class="mt-4 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                            
                            <div class="mt-6">
                                <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-900">
                                    &larr; Back to Menu
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @livewire('product-activity-tracker', ['productId' => $product->id])
</x-app-layout>
