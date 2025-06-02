<?php

namespace App\Livewire\UserProfile;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrderHistory extends Component
{
    use WithPagination;
    
    public $selectedOrder = null;
    
    public function viewOrderDetails($orderId)
    {
        $this->selectedOrder = Order::with(['items.product'])->find($orderId);
    }
    
    public function closeOrderDetails()
    {
        $this->selectedOrder = null;
    }
    
    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);
            
        return view('livewire.user-profile.order-history', [
            'orders' => $orders
        ]);
    }
}
