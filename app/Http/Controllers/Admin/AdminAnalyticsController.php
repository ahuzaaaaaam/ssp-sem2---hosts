<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
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
     * Display the analytics dashboard.
     */
    public function index(Request $request)
    {
        
        // Get sales data for the last 30 days
        $salesData = $this->getSalesData();
        
        // Get top selling products
        $topProducts = $this->getTopProducts();
        
        // Get user registration stats
        $userStats = $this->getUserStats();
        
        // Get order status distribution
        $orderStatusStats = $this->getOrderStatusStats();
        
        return view('admin.analytics.index', compact(
            'salesData',
            'topProducts',
            'userStats',
            'orderStatusStats'
        ));
    }
    
    /**
     * Get sales data for the last 30 days.
     */
    private function getSalesData()
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        
        $salesData = Order::where('created_at', '>=', $startDate)
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Format for chart display
        $formattedData = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');
            $dayData = $salesData->firstWhere('date', $dateString);
            
            $formattedData[] = [
                'date' => $currentDate->format('M d'),
                'revenue' => $dayData ? $dayData->revenue : 0,
                'count' => $dayData ? $dayData->count : 0
            ];
            
            $currentDate->addDay();
        }
        
        return $formattedData;
    }
    
    /**
     * Get top selling products.
     */
    private function getTopProducts()
    {
        // This is a simplified version - in a real app, you'd use a proper relationship
        // between orders and products through an order_items table
        return Product::select('products.*', DB::raw('COUNT(*) as order_count'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('order_count')
            ->limit(5)
            ->get();
    }
    
    /**
     * Get user registration statistics.
     */
    private function getUserStats()
    {
        return [
            'total' => User::count(),
            'new_this_month' => User::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'new_last_month' => User::whereBetween('created_at', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])->count(),
            'growth_percentage' => $this->calculateGrowthPercentage()
        ];
    }
    
    /**
     * Calculate user growth percentage.
     */
    private function calculateGrowthPercentage()
    {
        $lastMonth = User::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();
        
        $thisMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        
        if ($lastMonth == 0) {
            return $thisMonth > 0 ? 100 : 0;
        }
        
        return round((($thisMonth - $lastMonth) / $lastMonth) * 100, 2);
    }
    
    /**
     * Get order status distribution.
     */
    private function getOrderStatusStats()
    {
        return Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            });
    }
}
