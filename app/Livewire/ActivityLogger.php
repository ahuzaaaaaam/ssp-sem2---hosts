<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProductActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger extends Component
{
    /**
     * The activity type to log
     */
    public $activity;
    
    /**
     * The product ID to associate with the activity
     */
    public $productId = null;
    
    /**
     * Mount the component with default values
     */
    public function mount($activity = null, $productId = null)
    {
        $this->activity = $activity;
        $this->productId = $productId;
        
        // If activity is provided during mount, log it immediately
        if ($this->activity) {
            $this->logActivity();
        }
    }
    
    /**
     * Log an activity
     */
    public function logActivity($activity = null, $productId = null)
    {
        // Use parameters if provided, otherwise use component properties
        $activity = $activity ?? $this->activity;
        $productId = $productId ?? $this->productId;
        
        // Don't proceed if no activity is specified
        if (!$activity) {
            return;
        }
        
        // Create the activity log
        ProductActivityLog::create([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
            'activity'   => $activity,
            'ip'         => Request::ip(),
            'user_agent' => Request::userAgent(),
            'created_at' => now(),
        ]);
    }
    
    /**
     * Log a login activity
     */
    public function logLogin()
    {
        $this->logActivity('login');
    }
    
    /**
     * Log a logout activity
     */
    public function logLogout()
    {
        $this->logActivity('logout');
    }
    
    /**
     * Log a product view activity
     */
    public function logView($productId)
    {
        $this->logActivity('view', $productId);
    }
    
    /**
     * Log an add to cart activity
     */
    public function logAddToCart($productId)
    {
        $this->logActivity('add_to_cart', $productId);
    }
    
    /**
     * Log a purchase activity
     */
    public function logPurchase($productId)
    {
        $this->logActivity('purchase', $productId);
    }
    
    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.activity-logger');
    }
}
