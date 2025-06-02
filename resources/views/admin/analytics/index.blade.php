<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Analytics Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Sales Overview -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Sales Overview</h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Last 30 days</span>
                    </div>

                    <!-- Sales Chart -->
                    <div class="h-64 w-full">
                        <div class="flex items-end h-full space-x-1">
                            @foreach($salesData as $data)
                                @php
                                    $maxRevenue = max(array_column($salesData, 'revenue'));
                                    $height = $maxRevenue > 0 ? ($data['revenue'] / $maxRevenue) * 100 : 0;
                                @endphp
                                <div class="flex flex-col items-center flex-1">
                                    <div class="w-full bg-indigo-100 dark:bg-indigo-900 rounded-t" style="height: {{ $height }}%"></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $data['date'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sales Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format(array_sum(array_column($salesData, 'revenue')), 2) }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ array_sum(array_column($salesData, 'count')) }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Average Order Value</p>
                            @php
                                $totalOrders = array_sum(array_column($salesData, 'count'));
                                $totalRevenue = array_sum(array_column($salesData, 'revenue'));
                                $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
                            @endphp
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($avgOrderValue, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Top Products -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Top Products</h3>
                        </div>

                        <div class="space-y-4">
                            @foreach($topProducts as $product)
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $product->order_count }} orders</p>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- User Stats -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">User Statistics</h3>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $userStats['total'] }}</p>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">New Users This Month</p>
                                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $userStats['new_this_month'] }}</p>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Growth Rate</p>
                                    <p class="text-xl font-bold {{ $userStats['growth_percentage'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $userStats['growth_percentage'] >= 0 ? '+' : '' }}{{ $userStats['growth_percentage'] }}%
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Status Distribution -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mt-6">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Order Status Distribution</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $orderStatusStats['pending'] ?? 0 }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Processing</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $orderStatusStats['processing'] ?? 0 }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $orderStatusStats['completed'] ?? 0 }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cancelled</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $orderStatusStats['cancelled'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
