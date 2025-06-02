<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- In work, do what you enjoy. --}}
    <!-- Delivery and Payment Form -->
    <form wire:submit.prevent="placeOrder" class="space-y-8">
        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Customer Information</h2>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" value="{{ Auth::user()->first_name }}" readonly
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" value="{{ Auth::user()->last_name }}" readonly
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" value="{{ Auth::user()->phone }}" readonly
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                </div>
                <div class="pb-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" readonly
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                </div>
            </div>
            <a href="{{ route('cart.index') }}" class="block w-full text-center text-red-600 mt-4 hover:text-red-800">Back to Cart</a>
        </div>

        <!-- Payment Method -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
            <div class="space-y-4">
                <div>
                    <label class="flex items-center">
                        <input type="radio" wire:model="paymentMethod" value="cash" class="text-red-600">
                        <span class="ml-2">Cash on Delivery</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="radio" wire:model="paymentMethod" value="card" class="text-red-600">
                        <span class="ml-2">Credit/Debit Card</span>
                    </label>
                </div>
                @error('paymentMethod') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Delivery Address -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Delivery Address</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                    <input type="text" wire:model="address"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-red-500 focus:border-red-500">
                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" wire:model="city"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-red-500 focus:border-red-500">
                        @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                        <input type="text" wire:model="postalCode"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-red-500 focus:border-red-500">
                        @error('postalCode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <button type="submit"
            class="w-full bg-red-600 text-white text-center py-3 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
            Place Order
        </button>
    </form>

    <!-- Order Summary -->
    <div>
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
            <div class="space-y-4 mb-6">
                @foreach ($cartItems as $item)
                    <div class="flex justify-between">
                        <div>
                            <p class="font-semibold">{{ $item->item_name }} {{ $item->quantity > 1 ? "(x{$item->quantity})" : '' }}</p>
                            <p class="text-sm text-gray-600">{{ $item->description }}</p>
                        </div>
                        <p class="font-semibold">${{ number_format($item->price * $item->quantity, 2) }}</p>
                    </div>
                @endforeach
            </div>
            <!-- Totals -->
            <div class="space-y-3 border-t pt-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-semibold">${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Delivery Fee</span>
                    <span class="font-semibold">${{ number_format($deliveryFee, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tax</span>
                    <span class="font-semibold">${{ number_format($tax, 2) }}</span>
                </div>
                <div class="border-t pt-3 pb-4">
                    <div class="flex justify-between">
                        <span class="font-semibold">Total</span>
                        <span class="font-bold text-xl">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
