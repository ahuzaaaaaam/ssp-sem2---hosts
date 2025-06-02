<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomizeController extends Controller
{
    /**
     * Display the customize pizza form.
     */
    public function index()
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Prices for crusts and toppings (same as legacy app)
        $crustPrices = [
            'Classic Hand Tossed' => 0.00,
            'Thin Crust' => 2.50,
            'Stuffed Crust' => 4.00,
        ];
        
        $toppingPrices = [
            'Extra Cheese' => 1.50,
            'Pepperoni' => 2.00,
            'Mushrooms' => 1.20,
            'Bell Peppers' => 1.00,
            'Onions' => 0.80,
            'Olives' => 1.30,
        ];
        
        // Get cart count for the navigation badge
        $cartCount = 0;
        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->count();
        }
        
        return view('customize.index', [
            'crustPrices' => $crustPrices,
            'toppingPrices' => $toppingPrices,
            'cartCount' => $cartCount,
        ]);
    }
    
    /**
     * Store a custom pizza in the cart.
     */
    public function store(Request $request)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Get form data
        $crust = $request->input('crust', 'Classic Hand Tossed');
        $toppings = $request->input('toppings', []);
        
        // Prices for crusts and toppings (same as legacy app)
        $crustPrices = [
            'Classic Hand Tossed' => 0.00,
            'Thin Crust' => 2.50,
            'Stuffed Crust' => 4.00,
        ];
        
        $toppingPrices = [
            'Extra Cheese' => 1.50,
            'Pepperoni' => 2.00,
            'Mushrooms' => 1.20,
            'Bell Peppers' => 1.00,
            'Onions' => 0.80,
            'Olives' => 1.30,
        ];
        
        // Calculate price
        $basePrice = 10.99; // Base price for the custom pizza
        $crustPrice = $crustPrices[$crust] ?? 0;
        
        // Calculate the total toppings price
        $toppingsPrice = 0;
        foreach ($toppings as $topping) {
            $toppingsPrice += $toppingPrices[$topping] ?? 0;
        }
        
        // Total price
        $price = $basePrice + $crustPrice + $toppingsPrice;
        
        // Create description
        $description = "Crust: $crust";
        if (!empty($toppings)) {
            $description .= "; Toppings: " . implode(', ', $toppings);
        }
        
        // Add to cart
        Cart::create([
            'user_id' => Auth::id(),
            'item_name' => 'Custom Pizza',
            'description' => $description,
            'price' => $price,
            'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/9/91/Pizza-3007395.jpg',
        ]);
        
        return redirect()->route('cart.index')
            ->with('success', 'Custom pizza added to cart successfully!');
    }
}
