<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckoutForm extends Component
{
    public $address = '';
    public $city = '';
    public $postalCode = '';
    public $paymentMethod = 'cash';
    
    public $cartItems = [];
    public $subtotal = 0;
    public $tax = 0;
    public $deliveryFee = 5.00;
    public $total = 0;
    
    protected $rules = [
        'address' => 'required|string|min:5',
        'city' => 'required|string',
        'postalCode' => 'required|string',
        'paymentMethod' => 'required|in:cash,card',
    ];
    
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $this->refreshCart();
    }
    
    public function refreshCart()
    {
        $this->cartItems = Cart::where('user_id', Auth::id())->get();
        $this->calculateTotals();
    }
    
    private function calculateTotals()
    {
        $this->subtotal = $this->cartItems->sum(function ($item) {
            return $item->price * ($item->quantity ?? 1);
        });
        
        $this->tax = $this->subtotal * 0.1; // 10% tax
        $this->total = $this->subtotal + $this->tax + $this->deliveryFee;
    }
    
    public function placeOrder()
    {
        $this->validate();
        
        // Here you would typically save the order to a database
        // For this example, we'll just clear the cart
        
        // Clear the cart
        Cart::where('user_id', Auth::id())->delete();
        
        // Redirect to confirmation page
        return redirect()->route('order.confirmation', [
            'orderId' => 'ORD-' . rand(10000, 99999),
            'paymentMethod' => $this->paymentMethod,
            'address' => $this->address,
            'city' => $this->city,
            'postalCode' => $this->postalCode,
            'subtotal' => $this->subtotal,
            'deliveryFee' => $this->deliveryFee,
            'tax' => $this->tax,
            'total' => $this->total,
        ]);
    }
    
    public function render()
    {
        return view('livewire.checkout-form');
    }
}
