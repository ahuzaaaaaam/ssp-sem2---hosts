<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderManager extends Component
{
    use WithPagination;
    
    public $orderId;
    public $orderNumber;
    public $orderDate;
    public $customerName;
    public $customerEmail;
    public $subtotal;
    public $total;
    public $status;
    public $showModal = false;
    
    protected $listeners = ['openOrderModal' => 'openModal'];
    
    public function openModal($orderId)
    {
        $this->orderId = $orderId;
        $order = Order::findOrFail($orderId);
        
        $this->orderNumber = $order->order_number;
        $this->orderDate = $order->created_at->format('M d, Y');
        $this->customerName = $order->user->name;
        $this->customerEmail = $order->user->email;
        $this->subtotal = $order->subtotal;
        $this->total = $order->total;
        $this->status = $order->status;
        
        $this->showModal = true;
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['orderId', 'orderNumber', 'orderDate', 'customerName', 'customerEmail', 'subtotal', 'total', 'status']);
        
        // Dispatch event to notify that the modal has been closed
        $this->dispatch('orderModalClosed');
    }
    
    public function updateStatus()
    {
        $order = Order::findOrFail($this->orderId);
        $order->update([
            'status' => $this->status
        ]);
        
        $this->closeModal();
        session()->flash('success', 'Order status updated successfully.');
        
        // Get current URL and remove order parameter
        $url = request()->header('Referer');
        if (strpos($url, '?order=') !== false) {
            $url = preg_replace('/\?order=[0-9]+/', '', $url);
        } elseif (strpos($url, '&order=') !== false) {
            $url = preg_replace('/&order=[0-9]+/', '', $url);
        }
        
        // Redirect to the clean URL
        return redirect()->to($url);
    }
    
    public function render()
    {
        return view('livewire.admin.order-manager');
    }
}
