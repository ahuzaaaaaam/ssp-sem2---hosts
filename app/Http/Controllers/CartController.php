<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Cart items are now loaded by the Livewire component
        return view('cart.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not used in this application
        return redirect()->route('cart.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
        ]);
        
        // Add user_id to the validated data
        $validated['user_id'] = Auth::id();
        
        // Create cart item
        Cart::create($validated);
        
        return redirect()->route('cart.index')
            ->with('success', 'Item added to cart successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not used in this application
        return redirect()->route('cart.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Not used in this application
        return redirect()->route('cart.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Not used in this application
        return redirect()->route('cart.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Find the cart item
        $cartItem = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        // Delete the cart item
        $cartItem->delete();
        
        return redirect()->route('cart.index')
            ->with('success', 'Item removed from cart successfully!');
    }
    
    /**
     * Proceed to checkout page.
     */
    public function checkout()
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Checkout is now handled by the Livewire component
        return view('cart.checkout');
    }
    
    /**
     * Place an order.
     */
    public function placeOrder(Request $request)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Clear the cart
        Cart::where('user_id', Auth::id())->delete();
        
        // Redirect to the home page with a success message
        return redirect()->route('home')
            ->with('success', 'Your order has been placed successfully!');
    }
    
    /**
     * Add a custom pizza to the cart.
     */
    public function addCustomPizza(Request $request)
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
