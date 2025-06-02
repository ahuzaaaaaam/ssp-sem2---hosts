<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ProductActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ProductActivityLogger extends Component
{
    /**
     * The product ID to log activities for
     */
    public $productId;
    
    /**
     * Mount the component
     */
    public function mount($productId = null)
    {
        $this->productId = $productId;
        
        // Log product view when component is mounted
        if ($this->productId) {
            $this->logView();
        }
    }
    
    /**
     * Log a product view activity
     */
    public function logView()
    {
        if (!$this->productId) return;
        
        $this->logActivity('view');
    }
    
    /**
     * Log an add to cart activity
     */
    #[On('product-added-to-cart')]
    public function logAddToCart($productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) return;
        
        $this->logActivity('add_to_cart', $productId);
    }
    
    /**
     * Log a purchase activity
     */
    #[On('product-purchased')]
    public function logPurchase($productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) return;
        
        $this->logActivity('purchase', $productId);
    }
    
    /**
     * Log a wishlist add activity
     */
    #[On('product-added-to-wishlist')]
    public function logWishlistAdd($productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) return;
        
        $this->logActivity('wishlist_add', $productId);
    }
    
    /**
     * Log an activity
     */
    protected function logActivity($activity, $productId = null)
    {
        ProductActivityLog::create([
            'user_id'    => Auth::id(),
            'product_id' => $productId ?? $this->productId,
            'activity'   => $activity,
            'ip'         => Request::ip(),
            'user_agent' => Request::userAgent(),
            'created_at' => now(),
        ]);
    }
    
    public function render()
    {
        return view('livewire.products.product-activity-logger');
    }
}
