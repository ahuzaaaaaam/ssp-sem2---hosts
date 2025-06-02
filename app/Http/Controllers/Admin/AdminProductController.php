<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Admin check is handled by middleware
    
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        
        $products = Product::latest()->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }
    
    /**
     * Show the form for creating a new product.
     */
    public function create(Request $request)
    {
        
        return view('admin.products.create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
            'veg' => 'required|in:Yes,No',
            'featured' => 'required|in:Yes,No',
        ]);
        
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/products');
            $validated['image_url'] = Storage::url($path);
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }
    
    /**
     * Show the form for editing the specified product.
     */
    public function edit(Request $request, $id)
    {
        
        $product = Product::findOrFail($id);
        
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, $id)
    {
        
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
            'veg' => 'required|in:Yes,No',
            'featured' => 'required|in:Yes,No',
        ]);
        
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/products');
            $validated['image_url'] = Storage::url($path);
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Request $request, $id)
    {
        
        $product = Product::findOrFail($id);
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
