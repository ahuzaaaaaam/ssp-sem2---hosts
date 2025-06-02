@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center">
        <div class="mb-8">
            <svg class="mx-auto h-24 w-24 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Thank You for Your Order!</h1>
        <p class="text-lg text-gray-600 mb-8">Your order has been placed successfully.</p>
        
        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto mb-8">
            <h2 class="text-xl font-semibold mb-4">Order Details</h2>
            
            <div class="border-b pb-4 mb-4">
                <p class="text-gray-600 mb-1">Order ID: <span class="font-semibold">{{ $orderId ?? 'ORD-' . rand(10000, 99999) }}</span></p>
                <p class="text-gray-600 mb-1">Order Date: <span class="font-semibold">{{ now()->format('F j, Y, g:i a') }}</span></p>
                <p class="text-gray-600">Payment Method: <span class="font-semibold">{{ $paymentMethod ?? 'Cash on Delivery' }}</span></p>
            </div>
            
            <div class="border-b pb-4 mb-4">
                <h3 class="text-lg font-semibold mb-2">Delivery Address</h3>
                <p class="text-gray-600">{{ $address ?? '123 Main St' }}, {{ $city ?? 'Mumbai' }}, {{ $postalCode ?? '400001' }}</p>
            </div>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-semibold">${{ number_format($subtotal ?? 0, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Delivery Fee</span>
                    <span class="font-semibold">${{ number_format($deliveryFee ?? 0, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tax</span>
                    <span class="font-semibold">${{ number_format($tax ?? 0, 2) }}</span>
                </div>
                <div class="border-t pt-3">
                    <div class="flex justify-between">
                        <span class="font-semibold">Total</span>
                        <span class="font-bold text-xl">${{ number_format($total ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="space-x-4">
            <a href="{{ route('home') }}" class="inline-block bg-red-600 text-white px-6 py-3 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Return to Home
            </a>
            <a href="{{ route('products.index') }}" class="inline-block bg-gray-200 text-gray-800 px-6 py-3 rounded-full hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
