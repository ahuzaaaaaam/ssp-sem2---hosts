@extends('layouts.app')

@section('styles')
    @livewireStyles
@endsection

@section('content')
    @livewire('admin.order-manager')
    <!-- Hidden Livewire Product Manager for Edit Functionality -->
    <div class="hidden">
        @livewire('admin.product-manager')
    </div>
    
    <!-- Admin Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        @if (session('success'))
            <div class="max-w-md bg-white border border-gray-100 shadow-md rounded-md p-4 mb-6 flex items-center justify-between" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <p class="text-gray-800 font-medium">{{ session('success') }}</p>
                <button @click="show = false" class="text-gray-400 hover:text-gray-500 ml-4">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        @endif
    </div>
    <!-- Admin Dashboard Header -->
    <div class="bg-white py-8 px-4 sm:px-6 lg:px-8 mb-6 shadow-none border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">
            <h1 class="text-3xl font-bold text-black mb-2">Admin Dashboard</h1>
            <p class="text-gray-700">Welcome to the PizzApp Admin Panel. Manage your products, users, and orders.</p>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            
        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Products Stats -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0 p-3 rounded-full bg-red-50 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Products</p>
                        <div class="flex items-center">
                            <p class="text-gray-900 text-2xl font-bold">{{ $stats['products'] }}</p>
                            <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-red-50 text-red-600">+2 new</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Users Stats -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0 p-3 rounded-full bg-blue-50 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Users</p>
                        <div class="flex items-center">
                            <p class="text-gray-900 text-2xl font-bold">{{ $stats['users'] }}</p>
                            <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-blue-50 text-blue-600">{{ $newUsersThisMonth }} new</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Orders Stats -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0 p-3 rounded-full bg-green-50 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Orders</p>
                        <div class="flex items-center">
                            <p class="text-gray-900 text-2xl font-bold">{{ $stats['orders'] }}</p>
                            <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-green-50 text-green-600">{{ count($recentOrders) }} recent</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Revenue Stats -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0 p-3 rounded-full bg-yellow-50 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Revenue</p>
                        <div class="flex items-center">
                            <p class="text-gray-900 text-2xl font-bold">${{ number_format($stats['revenue'], 2) }}</p>
                            <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-50 text-yellow-600">This month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions Section -->
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="px-6 py-4">
                    <h2 class="text-lg font-bold text-gray-800">Quick Actions</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                    <!-- Products Card -->
                    <a href="{{ route('admin.products.index') }}" class="bg-white rounded-xl border border-gray-300 hover:border-red-400 transition-all duration-300 p-4 flex flex-col items-center text-center group">
                        <div class="p-3 rounded-full bg-red-50 mb-3 group-hover:bg-red-100 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2 text-center text-lg">Products</h3>
                        <p class="text-gray-600 text-sm text-center w-full font-medium">Manage product catalog</p>
                    </a>
                    
                    <!-- Activity Logs Card -->
                    <a href="{{ route('admin.activity-logs.index') }}" class="bg-white rounded-xl border border-gray-300 hover:border-blue-400 transition-all duration-300 p-4 flex flex-col items-center text-center group">
                        <div class="p-3 rounded-full bg-blue-50 mb-3 group-hover:bg-blue-100 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2 text-center text-lg">Activity Logs</h3>
                        <p class="text-gray-600 text-sm text-center w-full font-medium">View product activity logs</p>
                    </a>
                    
                    <!-- Orders Card -->
                    <a href="{{ route('admin.orders.index') }}" class="bg-white rounded-xl border border-gray-300 hover:border-green-400 transition-all duration-300 p-4 flex flex-col items-center text-center group">
                        <div class="p-3 rounded-full bg-green-50 mb-3 group-hover:bg-green-100 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2 text-center text-lg">Orders</h3>
                        <p class="text-gray-600 text-sm text-center w-full font-medium">View and process orders</p>
                    </a>
                </div>
            </div>
        </div>
            
        <!-- Recent Products and Orders Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Recent Products -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Recent Products</h3>
                    <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
                </div>
                <div class="p-6">
                    @if(count($recentProducts) > 0)
                        <div class="space-y-4">
                            @foreach($recentProducts as $product)
                                <div class="bg-white border border-gray-100 rounded-lg p-4 shadow-md">
                                    <div class="flex items-center">
                                        <!-- Product Image (Left) - Fixed Square -->
                                        <div class="flex-shrink-0" style="width: 64px; height: 64px;">
                                            @if($product->image_url)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 64px; height: 64px; object-fit: cover;" class="rounded">
                                            @else
                                                <div style="width: 64px; height: 64px;" class="flex items-center justify-center bg-gray-100 rounded">
                                                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Product Details (Middle) -->
                                        <div class="ml-4 flex-1">
                                            <h4 class="text-lg font-bold text-gray-900">{{ $product->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ Str::limit($product->description, 100) }}</p>
                                        </div>
                                        
                                        <!-- Price and Actions (Right) -->
                                        <div class="flex-shrink-0 flex flex-col items-end justify-center" style="min-width: 100px;">
                                            <span class="text-lg font-bold text-gray-900 mb-3 text-center w-full">${{ number_format($product->price, 2) }}</span>
                                            <div class="flex justify-center w-full">
                                                <a href="{{ route('admin.products.index') }}?edit={{ $product->id }}" class="inline-block px-2 py-1 text-sm text-blue-600 hover:text-blue-800 font-medium mr-3">Edit</a>
                                                <a href="{{ route('admin.products.destroy', $product->id) }}" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this product?')) document.getElementById('delete-product-{{ $product->id }}').submit();" class="inline-block px-2 py-1 text-sm text-red-600 hover:text-red-800 font-medium">Delete</a>
                                                <form id="delete-product-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No products yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new product.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-md text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Product
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Recent Orders</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
                </div>
                <div class="p-6">
                    @if(count($recentOrders) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Order</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Customer</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($recentOrders as $order)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                                <div class="text-xs text-gray-500">${{ number_format($order->total, 2) }} · {{ $order->created_at->format('M d, Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($order->status === 'completed')
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-green-50 text-green-700">Completed</span>
                                                @elseif($order->status === 'processing')
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-blue-50 text-blue-700">Processing</span>
                                                @elseif($order->status === 'pending')
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-yellow-50 text-yellow-700">Pending</span>
                                                @else
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-red-50 text-red-700">{{ ucfirst($order->status) }}</span>
                                                @endif
                                            </td>
                                             <td class="px-6 py-4 text-right text-sm font-medium">
                                                 <a href="{{ route('admin.orders.index') }}?order={{ $order->id }}" class="text-blue-600 hover:text-blue-900 font-medium">View</a>
                                             </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No orders yet</h3>
                            <p class="mt-1 text-sm text-gray-500">New orders will appear here once customers start placing them.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        

        
    </div>
    
    <!-- Order modal is now handled by the Livewire component -->
    
    <!-- All order modal JavaScript has been replaced by Livewire -->
@endsection

@section('scripts')
    @livewireScripts
    <script>
        // This function will now trigger the Livewire component
        function openOrderModalLivewire(orderId) {
            Livewire.dispatch('openOrderModal', { orderId: orderId });
        }
    </script>
@endsection


