<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminApiController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Check if the user is an admin.
     */
    private function checkAdmin(Request $request)
    {
        if (!$request->user() || $request->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You do not have permission to access the admin area.');
        }
        
        return null;
    }
    
    /**
     * Display the API documentation.
     */
    public function index(Request $request)
    {
        if ($redirect = $this->checkAdmin($request)) {
            return $redirect;
        }
        
        // API endpoints documentation
        $endpoints = [
            [
                'name' => 'Products API',
                'description' => 'Endpoints for retrieving product information',
                'routes' => [
                    [
                        'method' => 'GET',
                        'url' => '/api/products',
                        'description' => 'Get all products',
                        'parameters' => 'None'
                    ],
                    [
                        'method' => 'GET',
                        'url' => '/api/products/{id}',
                        'description' => 'Get a specific product by ID',
                        'parameters' => 'id: Product ID (integer)'
                    ]
                ]
            ],
            [
                'name' => 'Orders API',
                'description' => 'Endpoints for managing orders',
                'routes' => [
                    [
                        'method' => 'GET',
                        'url' => '/api/orders',
                        'description' => 'Get all orders (requires authentication)',
                        'parameters' => 'Bearer token'
                    ],
                    [
                        'method' => 'POST',
                        'url' => '/api/orders',
                        'description' => 'Create a new order',
                        'parameters' => 'products: array of product IDs and quantities'
                    ]
                ]
            ]
        ];
        
        return view('admin.api.index', compact('endpoints'));
    }
}
