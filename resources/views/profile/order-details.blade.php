<x-app-layout>
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('profile.orders') }}" class="inline-flex items-center text-red-600 hover:text-red-800">
                <i class="fas fa-arrow-left mr-2"></i> Back to Order History
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</h1>
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        @if($order->status == 'completed') bg-green-100 text-green-800
                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">Placed on {{ $order->created_at->format('F j, Y, g:i a') }}</p>
            </div>

            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold mb-4">Order Items</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Options</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($item->product && $item->product->image)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product ? $item->product->name : 'Product' }}">
                                        </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item->product ? $item->product->name : 'Product not available' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($item->options)
                                            @if(isset($item->options['crust']))
                                                <div><span class="font-medium">Crust:</span> {{ $item->options['crust'] }}</div>
                                            @endif
                                            
                                            @if(isset($item->options['toppings']) && count($item->options['toppings']) > 0)
                                                <div>
                                                    <span class="font-medium">Toppings:</span> 
                                                    {{ implode(', ', $item->options['toppings']) }}
                                                </div>
                                            @endif
                                        @else
                                            Standard
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">${{ number_format($item->price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between">
                    <div class="w-1/2">
                        <h2 class="text-lg font-semibold mb-4">Shipping Address</h2>
                        <address class="not-italic">
                            <p>{{ $order->address_line1 }}</p>
                            @if($order->address_line2)
                                <p>{{ $order->address_line2 }}</p>
                            @endif
                            <p>{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}</p>
                        </address>
                    </div>
                    <div class="w-1/2">
                        <h2 class="text-lg font-semibold mb-4">Payment Information</h2>
                        <p><span class="font-medium">Method:</span> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                        <p><span class="font-medium">Status:</span> 
                            <span class="@if($order->payment_status == 'paid') text-green-600 @elseif($order->payment_status == 'failed') text-red-600 @else text-yellow-600 @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-gray-50">
                <div class="flex justify-end">
                    <div class="w-64">
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Tax:</span>
                            <span class="font-medium">${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-gray-200 font-bold">
                            <span>Total:</span>
                            <span>${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
