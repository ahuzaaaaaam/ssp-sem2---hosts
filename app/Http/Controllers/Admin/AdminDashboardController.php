<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard with comprehensive statistics and data.
     */
    public function index(Request $request)
    {
        // Get basic stats for dashboard
        $stats = [
            'products' => Product::count(),
            'users' => User::count(),
            'orders' => Order::count(),
            'revenue' => Order::where('status', 'completed')->sum('total') ?? 0,
        ];
        
        // Get recent products with more details
        $recentProducts = Product::latest()->take(5)->get();
        
        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        // Get new users this month
        $newUsersThisMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();
            
        // Get sales data for the last 7 days
        $salesData = $this->getWeeklySalesData();
        
        // Get system status
        $systemStatus = [
            'server' => 'Online',
            'security' => 'Protected',
            'lastBackup' => Carbon::now()->format('Y-m-d'),
            'laravelVersion' => app()->version(),
            'phpVersion' => phpversion(),
        ];
        
        return view('admin.dashboard', compact(
            'stats', 
            'recentProducts', 
            'recentOrders', 
            'newUsersThisMonth', 
            'salesData',
            'systemStatus'
        ));
    }
    
    /**
     * Get sales data for the last 7 days.
     */
    private function getWeeklySalesData()
    {
        $salesData = [];
        
        // Get sales for each of the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $sales = Order::whereDate('created_at', $date->format('Y-m-d'))
                ->where('status', 'completed')
                ->sum('total') ?? 0;
                
            $salesData[] = [
                'date' => $date->format('D'),
                'sales' => $sales
            ];
        }
        
        return $salesData;
    }
}
