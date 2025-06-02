<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Address;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index()
    {
        return view('profile.index');
    }
    
    /**
     * Display the user's order history.
     */
    public function orderHistory()
    {
        $orders = Auth::user()->orders()->paginate(10);
        return view('profile.order-history', compact('orders'));
    }
    
    /**
     * Display a specific order's details.
     */
    public function orderDetails($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('profile.order-details', compact('order'));
    }
    
    /**
     * Display the user's address management page.
     */
    public function addresses()
    {
        $addresses = Auth::user()->addresses;
        return view('profile.addresses', compact('addresses'));
    }
}
