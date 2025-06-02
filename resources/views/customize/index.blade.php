@extends('layouts.app')

@section('title', 'Customize Pizza')

@section('content')
<div class="pt-8 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Customize Your Pizza</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Pizza Preview -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591" alt="Custom Pizza"
                    class="w-full h-64 object-cover rounded-lg mb-6">
                <h2 class="text-2xl font-bold text-center mb-2">Your Custom Pizza</h2>
                <p class="text-gray-600 text-center mb-4">Price starts at $10.99</p>
                
                <!-- Dynamic Price Calculator -->
                <div class="mt-6 py-3">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-lg">Total Price:</span>
                        <span class="text-2xl font-bold text-red-600" id="total-price">$10.99</span>
                    </div>
                </div>
            </div>

            <!-- Customization Options -->
            <form method="POST" action="{{ route('customize.store') }}" class="space-y-8">
                @csrf
                <!-- Crust Selection -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Select Your Crust</h3>
                    <div class="space-y-2">
                        @foreach ($crustPrices as $crust => $price)
                            <label
                                class="flex items-center p-3 bg-white rounded-lg border {{ $crust === 'Classic Hand Tossed' ? 'border-red-600' : '' }} hover:border-red-600 cursor-pointer">
                                <input type="radio" name="crust" value="{{ $crust }}" class="text-red-600"
                                    {{ $crust === 'Classic Hand Tossed' ? 'checked' : '' }}>
                                <span class="ml-2">
                                    @if ($crust === 'Classic Hand Tossed')
                                        {{ $crust }}
                                    @else
                                        {{ $crust }} (+${{ number_format($price, 2) }})
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Toppings Selection -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Select Your Toppings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($toppingPrices as $topping => $price)
                            <label
                                class="flex items-center p-3 bg-white rounded-lg border hover:border-red-600 cursor-pointer">
                                <input type="checkbox" name="toppings[]" value="{{ $topping }}" class="text-red-600">
                                <span class="ml-2">{{ $topping }} (+${{ number_format($price, 2) }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <button type="submit"
                    class="w-full bg-red-600 text-white py-3 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Base price
        const basePrice = 10.99;
        
        // Get all crust radio buttons
        const crustRadios = document.querySelectorAll('input[name="crust"]');
        
        // Get all topping checkboxes
        const toppingCheckboxes = document.querySelectorAll('input[name="toppings[]"]');
        
        // Element to update
        const totalPriceElement = document.getElementById('total-price');
        
        // Initialize crust prices from PHP
        const crustPrices = {
            @foreach ($crustPrices as $crust => $price)
                '{{ $crust }}': {{ $price }},
            @endforeach
        };
        
        // Initialize topping prices from PHP
        const toppingPrices = {
            @foreach ($toppingPrices as $topping => $price)
                '{{ $topping }}': {{ $price }},
            @endforeach
        };
        
        // Function to update the total price
        function updateTotalPrice() {
            let total = basePrice;
            
            // Add selected crust price (except for Classic Hand Tossed which is included in base price)
            crustRadios.forEach(radio => {
                if (radio.checked && radio.value !== 'Classic Hand Tossed') {
                    const crustPrice = crustPrices[radio.value];
                    total += crustPrice;
                }
            });
            
            // Add selected toppings prices
            toppingCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const price = toppingPrices[checkbox.value];
                    total += price;
                }
            });
            
            // Update total price display
            totalPriceElement.textContent = `$${total.toFixed(2)}`;
        }
        
        // Add event listeners to all crust options
        crustRadios.forEach(radio => {
            radio.addEventListener('change', updateTotalPrice);
        });
        
        // Add event listeners to all topping checkboxes
        toppingCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateTotalPrice);
        });
        
        // Initialize with default values
        updateTotalPrice();
    });
</script>
@endsection
