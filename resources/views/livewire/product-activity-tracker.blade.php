<div>
    {{-- This component logs product activities --}}
    
    {{-- Wire:init will call the logView method when the component is initialized --}}
    <div wire:init="logView" class="hidden"></div>
    
    {{-- Add event listeners for product actions --}}
    @if($productId)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Listen for add to cart button clicks
                const addToCartButtons = document.querySelectorAll('button[data-product-id="{{ $productId }}"], a[data-product-id="{{ $productId }}"]');
                addToCartButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        Livewire.dispatch('product-added-to-cart', { productId: {{ $productId }} });
                    });
                });
                
                // Listen for purchase events
                document.addEventListener('purchase-completed', function(e) {
                    if (e.detail && e.detail.productId == {{ $productId }}) {
                        Livewire.dispatch('product-purchased', { productId: {{ $productId }} });
                    }
                });
            });
        </script>
    @endif
</div>
