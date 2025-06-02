<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // The products are now loaded and filtered by the Livewire component
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only admins can access this
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('products.index');
        }
        
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only admins can access this
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('products.index');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'required|url',
            'veg' => 'required|in:Yes,No',
            'featured' => 'required|in:Yes,No',
        ]);
        
        Product::create($validated);
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        
        return view('products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Only admins can access this
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('products.index');
        }
        
        $product = Product::findOrFail($id);
        
        return view('products.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Only admins can access this
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('products.index');
        }
        
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'required|url',
            'veg' => 'required|in:Yes,No',
            'featured' => 'required|in:Yes,No',
        ]);
        
        $product->update($validated);
        
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Only admins can access this
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('products.index');
        }
        
        $product = Product::findOrFail($id);
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
    
    /**
     * Display a listing of the featured products.
     */
    public function featured()
    {
        $products = Product::where('featured', 'Yes')->get();
        
        return view('home', [
            'products' => $products,
        ]);
    }
    
    /**
     * Add a product to the cart.
     */
    public function addToCart(string $id)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $product = Product::findOrFail($id);
        
        // Check if the product is already in the cart
        $existingCartItem = Cart::where('user_id', Auth::id())
            ->where('item_name', $product->name)
            ->first();
            
        if ($existingCartItem) {
            // If it exists, increment the quantity
            $existingCartItem->quantity += 1;
            $existingCartItem->save();
        } else {
            // Otherwise, add a new item
            Cart::create([
                'user_id' => Auth::id(),
                'item_name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'image_url' => $product->image_url,
                'quantity' => 1,
            ]);
        }
        
        // Use a proper event to notify components
        // We'll use a simple approach without custom events
        session()->flash('cart_updated', true);
        
        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }
}
