<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductActivityLog;
use Illuminate\Http\Request;

class ProductActivityLogController extends Controller
{
    // Store a new activity log via API (for compatibility with older code)
    public function store(Request $request)
    {
        // Validate the request - product_id can be null for login/logout activities
        $validated = $request->validate([
            'activity' => 'required|string',
            'product_id' => 'nullable',
        ]);
        
        // List of valid activities - add more as needed
        $validActivities = [
            'view', 'add_to_cart', 'purchase', 'login', 'logout', 'page_visit',
            'wishlist_add', 'search', 'review'
        ];
        
        // Default to 'page_visit' if activity is not recognized
        $activity = in_array($request->input('activity'), $validActivities) 
            ? $request->input('activity') 
            : 'page_visit';
        
        // Create the log entry
        $log = ProductActivityLog::create([
            'user_id'    => $request->user() ? $request->user()->id : null,
            'product_id' => $request->input('product_id'),
            'activity'   => $activity,
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);
        
        // Return success response with the created log
        return response()->json([
            'success' => true,
            'message' => 'Activity logged successfully',
            'data' => $log
        ], 201);
    }

    // Get the most viewed products (aggregation)
    public function mostViewed()
    {
        $result = ProductActivityLog::raw(function($collection) {
            return $collection->aggregate([
                ['$match' => ['activity' => 'view']],
                ['$group' => [
                    '_id' => '$product_id',
                    'views' => ['$sum' => 1]
                ]],
                ['$sort' => ['views' => -1]],
                ['$limit' => 10]
            ]);
        });
        return response()->json($result->toArray());
    }
}
