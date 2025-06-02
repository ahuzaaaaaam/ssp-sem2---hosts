<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ProductActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LoginLogger extends Component
{
    /**
     * Log user activity when component is initialized
     */
    public function logUserActivity()
    {
        if (Auth::check()) {
            $this->logActivity('page_visit');
        }
    }
    
    /**
     * Log user login activity
     */
    #[On('user-logged-in')]
    public function logLogin()
    {
        $this->logActivity('login');
    }
    
    /**
     * Log user logout activity
     */
    #[On('user-logged-out')]
    public function logLogout()
    {
        $this->logActivity('logout');
    }
    
    /**
     * Log an activity
     */
    protected function logActivity($activity, $productId = null)
    {
        ProductActivityLog::create([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
            'activity'   => $activity,
            'ip'         => Request::ip(),
            'user_agent' => Request::userAgent(),
            'created_at' => now(),
        ]);
    }
    
    public function render()
    {
        return view('livewire.auth.login-logger');
    }
}
