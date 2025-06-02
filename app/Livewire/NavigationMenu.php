<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavigationMenu extends Component
{
    protected $listeners = ['cartUpdated' => 'render'];
    
    public function logout()
    {
        Auth::logout();
        
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('home');
    }
    
    public function render()
    {
        $cartCount = 0;
        
        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        }
        
        return view('livewire.navigation-menu', [
            'cartCount' => $cartCount,
        ]);
    }
}
