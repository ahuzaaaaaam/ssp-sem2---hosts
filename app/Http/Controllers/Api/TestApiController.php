<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestApiController extends Controller
{
    /**
     * Simple test endpoint to verify API functionality
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function test()
    {
        return response()->json([
            'success' => true,
            'message' => 'API is working correctly',
            'time' => now()->toDateTimeString(),
            'environment' => app()->environment()
        ]);
    }
    
    /**
     * Echo back the request information for debugging
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function echo(Request $request)
    {
        return response()->json([
            'success' => true,
            'headers' => $request->headers->all(),
            'method' => $request->method(),
            'path' => $request->path(),
            'url' => $request->url(),
            'input' => $request->all()
        ]);
    }
}
