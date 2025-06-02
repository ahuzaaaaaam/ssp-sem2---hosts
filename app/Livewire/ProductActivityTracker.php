<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ProductActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ProductActivityTracker extends Component
{
    /**
     * The product ID to track
     */
    public $productId;
    
    /**
     * Mount the component
     */
    public function mount($productId = null)
    {
        $this->productId = $productId;
    }
    
    /**
     * Log product view
     */
    public function logView()
    {
        if (!$this->productId) return;
        
        $this->logActivity('view');
    }
    
    /**
     * Log add to cart
     */
    #[On('product-added-to-cart')]
    public function logAddToCart($productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) return;
        
        $this->logActivity('add_to_cart', $productId);
    }
    
    /**
     * Log purchase
     */
    #[On('product-purchased')]
    public function logPurchase($productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) return;
        
        $this->logActivity('purchase', $productId);
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
    
    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.product-activity-tracker');
    }
}
