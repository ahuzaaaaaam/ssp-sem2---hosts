<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the admin dashboard with statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Get counts for dashboard statistics
        $stats = [
            'products' => Product::count(),
            'users' => User::count(),
            'orders' => Order::count() ?? 0,
            'revenue' => Order::sum('total_amount') ?? 0,
        ];
        
        // Get recent products
        $recentProducts = Product::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentProducts'));
    }
    
    /**
     * Display a listing of all products.
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }
    
    /**
     * Display a listing of all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Display a listing of all orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
}
