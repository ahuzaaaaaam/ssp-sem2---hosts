<div>
    @if($selectedOrder)
        <!-- Order Details Modal -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Order #{{ $selectedOrder->id }}</h3>
                        <button wire:click="closeOrderDetails" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Ordered on {{ $selectedOrder->created_at->format('F j, Y, g:i a') }}</p>
                        <p class="text-sm text-gray-600">Status: 
                            <span class="font-medium 
                                @if($selectedOrder->status === 'completed') text-green-600
                                @elseif($selectedOrder->status === 'processing') text-blue-600
                                @elseif($selectedOrder->status === 'cancelled') text-red-600
                                @else text-yellow-600 @endif">
                                {{ ucfirst($selectedOrder->status) }}
                            </span>
                        </p>
                    </div>
                    
                    <div class="border-t border-b border-gray-200 py-4 mb-4">
                        <h4 class="font-medium mb-2">Items</h4>
                        <div class="space-y-3">
                            @foreach($selectedOrder->items as $item)
                                <div class="flex items-center">
                                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h5 class="text-sm font-medium">{{ $item->product->name }}</h5>
                                        <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                        <p class="text-sm font-medium">${{ number_format($item->price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Subtotal</span>
                            <span class="text-sm font-medium">${{ number_format($selectedOrder->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tax</span>
                            <span class="text-sm font-medium">${{ number_format($selectedOrder->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-2 mt-2">
                            <span class="font-medium">Total</span>
                            <span class="font-bold text-red-600">${{ number_format($selectedOrder->total, 2) }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="font-medium mb-2">Shipping Address</h4>
                        <address class="text-sm text-gray-600 not-italic">
                            {{ $selectedOrder->address_line1 }}<br>
                            @if($selectedOrder->address_line2)
                                {{ $selectedOrder->address_line2 }}<br>
                            @endif
                            {{ $selectedOrder->city }}, {{ $selectedOrder->state }} {{ $selectedOrder->postal_code }}
                        </address>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Order History</h2>
        
        @if($orders->isEmpty())
            <div class="text-center py-8">
                <div class="text-red-600 mb-2">
                    <i class="fas fa-shopping-bag text-5xl"></i>
                </div>
                <p class="text-gray-600 mb-4">You haven't placed any orders yet.</p>
                <a href="{{ route('menu') }}" class="inline-block bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Browse Menu
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order #
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($order->status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button wire:click="viewOrderDetails({{ $order->id }})" class="text-red-600 hover:text-red-900">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
