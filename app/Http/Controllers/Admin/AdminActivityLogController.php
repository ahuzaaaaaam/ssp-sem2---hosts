<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductActivityLog;
use Illuminate\Http\Request;

class AdminActivityLogController extends Controller
{
    /**
     * Display a listing of the product activity logs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all logs from MongoDB, sorted by most recent first
        $logs = ProductActivityLog::orderBy('created_at', 'desc')->paginate(20);
        
        // Get the most viewed products for analytics
        $mostViewed = ProductActivityLog::raw(function($collection) {
            return $collection->aggregate([
                ['$match' => ['activity' => 'view']],
                ['$group' => [
                    '_id' => '$product_id',
                    'views' => ['$sum' => 1]
                ]],
                ['$sort' => ['views' => -1]],
                ['$limit' => 10]
            ]);
        })->toArray();
        
        // Get activity counts by type
        $activityCounts = ProductActivityLog::raw(function($collection) {
            return $collection->aggregate([
                ['$group' => [
                    '_id' => '$activity',
                    'count' => ['$sum' => 1]
                ]],
                ['$sort' => ['count' => -1]]
            ]);
        })->toArray();
        
        return view('admin.activity_logs.index', compact('logs', 'mostViewed', 'activityCounts'));
    }
    
    /**
     * Display details for a specific product's activity.
     *
     * @param  int  $productId
     * @return \Illuminate\View\View
     */
    public function productDetails($productId)
    {
        if (!$productId || !is_numeric($productId)) {
            return redirect()->route('admin.activity-logs.index')
                             ->with('error', 'Invalid product ID provided');
        }
        
        // Get all logs for a specific product
        $logs = ProductActivityLog::where('product_id', $productId)
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(20);
        
        // Get activity counts for this product
        $activityCounts = ProductActivityLog::raw(function($collection) use ($productId) {
            return $collection->aggregate([
                ['$match' => ['product_id' => $productId]],
                ['$group' => [
                    '_id' => '$activity',
                    'count' => ['$sum' => 1]
                ]],
                ['$sort' => ['count' => -1]]
            ]);
        })->toArray();
        
        return view('admin.activity_logs.product_details', compact('logs', 'activityCounts', 'productId'));
    }
}
