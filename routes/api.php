<?php

use App\Http\Controllers\Api\AuthTokenController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\FixedApiController;
use App\Http\Controllers\Api\TestApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductActivityLogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API endpoints
Route::get('test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is working correctly',
        'time' => now()->toDateTimeString()
    ]);
});

Route::get('products', [FixedApiController::class, 'getProducts']);
Route::get('products/{id}', [FixedApiController::class, 'getProduct']);

// Authentication endpoints
Route::post('tokens', [AuthTokenController::class, 'createToken']);

// Product Activity Log (MongoDB)
Route::post('product-activity', [ProductActivityLogController::class, 'store']);
Route::get('product-activity/most-viewed', [ProductActivityLogController::class, 'mostViewed']);

// Protected API endpoints
Route::middleware('auth:sanctum')->group(function () {
    // User info
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    
    // Token management
    Route::delete('tokens', [AuthTokenController::class, 'revokeTokens']);
    Route::delete('tokens/{tokenId}', [AuthTokenController::class, 'revokeToken']);
    
    // Admin-only endpoints
    Route::middleware('api.admin')->group(function () {
        Route::post('products', [ProductApiController::class, 'store']);
        Route::put('products/{id}', [ProductApiController::class, 'update']);
        Route::delete('products/{id}', [ProductApiController::class, 'destroy']);
    });
});
