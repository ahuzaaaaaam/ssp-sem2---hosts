<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-gray-50">

    @if(count($cartItems) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex">
                                <!-- Product Image -->
                                <div class="w-16 h-16 flex-shrink-0">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->item_name }}" class="w-16 h-16 object-cover rounded" style="max-width: 64px; max-height: 64px;">
                                </div>
                                
                                <!-- Product Details -->
                                <div class="ml-4">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $item->item_name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item->description }}</p>
                                </div>
                            </div>
                            
                            <!-- Price, Quantity Controls, and Remove -->
                            <div class="flex flex-col items-end space-y-2">
                                <span class="text-lg font-bold">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                
                                <!-- Quantity Controls -->
                                <div class="flex items-center mt-1 mb-2">
                                    <button wire:click="decrementQuantity({{ $item->id }})" class="mr-6 text-gray-700 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 transition-colors duration-200 rounded-md w-8 h-8 flex items-center justify-center focus:outline-none">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <span class="font-medium text-gray-800 text-lg px-2">{{ $item->quantity }}</span>
                                    <button wire:click="incrementQuantity({{ $item->id }})" class="ml-6 text-gray-700 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 transition-colors duration-200 rounded-md w-8 h-8 flex items-center justify-center focus:outline-none">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                                
                                <button wire:click="removeItem({{ $item->id }})" class="text-red-600 hover:text-red-800 text-sm font-medium transition-colors duration-200">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Subtotal</span>
                            <span class="font-semibold">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Delivery Fee</span>
                            <span class="font-semibold">${{ number_format($deliveryFee, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Tax</span>
                            <span class="font-semibold">${{ number_format($tax, 2) }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center py-3 mt-3 border-t border-gray-200 mb-4">
                        <span class="text-lg font-bold">Total</span>
                        <span class="text-lg font-bold">${{ number_format($total, 2) }}</span>
                    </div>
                    <a href="{{ route('checkout') }}" class="block w-full bg-red-600 text-white text-center py-3 rounded-lg font-medium hover:bg-red-700 focus:outline-none transition-colors duration-200">
                        Proceed to Checkout
                    </a>
                    <a href="{{ route('products.index') }}" class="block w-full text-center py-2 mt-2 text-gray-600 hover:text-gray-800">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow max-w-md mx-auto">
            <!-- Empty Cart Icon -->
            <i class="fas fa-shopping-cart text-red-500 text-4xl mb-6"></i>
            <h2 class="text-2xl font-medium text-gray-900 mb-3">Your cart is empty</h2>
            <p class="text-gray-600 mb-8 max-w-xs mx-auto">Looks like you haven't added any items to your cart yet.</p>
            <a href="{{ route('products.index') }}" class="inline-block px-8 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors duration-200 shadow-sm">
                Browse Menu
            </a>
        </div>
    @endif
</div>
