<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShoppingCart extends Component
{
    public $cartItems = [];
    public $subtotal = 0;
    public $tax = 0;
    public $deliveryFee = 5.00;
    public $total = 0;
    
    public function mount()
    {
        $this->refreshCart();
    }
    
    public function refreshCart()
    {
        if (Auth::check()) {
            $this->cartItems = Cart::where('user_id', Auth::id())->get();
            $this->calculateTotals();
        }
    }
    
    public function removeItem($itemId)
    {
        $cartItem = Cart::find($itemId);
        
        if ($cartItem && $cartItem->user_id === Auth::id()) {
            $cartItem->delete();
            $this->refreshCart();
            $this->dispatch('cart-updated');
        }
    }
    
    public function updateQuantity($itemId, $quantity)
    {
        if ($quantity < 1) {
            $quantity = 1;
        }
        
        $cartItem = Cart::find($itemId);
        
        if ($cartItem && $cartItem->user_id === Auth::id()) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
            $this->refreshCart();
            $this->dispatch('cart-updated');
        }
    }
    
    public function incrementQuantity($itemId)
    {
        $cartItem = Cart::find($itemId);
        
        if ($cartItem && $cartItem->user_id === Auth::id()) {
            $this->updateQuantity($itemId, $cartItem->quantity + 1);
        }
    }
    
    public function decrementQuantity($itemId)
    {
        $cartItem = Cart::find($itemId);
        
        if ($cartItem && $cartItem->user_id === Auth::id()) {
            if ($cartItem->quantity > 1) {
                $this->updateQuantity($itemId, $cartItem->quantity - 1);
            } else {
                // If quantity would become 0, remove the item
                $this->removeItem($itemId);
            }
        }
    }
    
    private function calculateTotals()
    {
        $this->subtotal = $this->cartItems->sum(function ($item) {
            return $item->price * ($item->quantity ?? 1);
        });
        
        $this->tax = $this->subtotal * 0.1; // 10% tax
        $this->total = $this->subtotal + $this->tax + $this->deliveryFee;
    }
    
    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
