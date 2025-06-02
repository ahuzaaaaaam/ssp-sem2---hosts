<div>
    {{-- This is an invisible component that logs product activities --}}
    {{-- It is included on product pages to track user interactions --}}
    
    {{-- Wire:init will call the logView method when the component is initialized --}}
    <div wire:init="logView" class="hidden"></div>
    
    {{-- Add event listeners for product actions --}}
    @if($productId)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Listen for add to cart button clicks
                const addToCartButtons = document.querySelectorAll('button[form*="add-to-cart"], a[href*="add-to-cart"]');
                addToCartButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        Livewire.dispatch('product-added-to-cart', { productId: {{ $productId }} });
                    });
                });
                
                // Listen for purchase events
                document.addEventListener('purchase-completed', function(e) {
                    if (e.detail && e.detail.productId) {
                        Livewire.dispatch('product-purchased', { productId: e.detail.productId });
                    }
                });
            });
        </script>
    @endif
</div>
