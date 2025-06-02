<div>
    <!-- Order Modal -->
    <div id="livewireOrderModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto h-full w-full {{ $showModal ? 'flex items-center justify-center' : 'hidden' }}" x-data>
        <div class="relative mx-auto w-full max-w-2xl bg-white rounded-xl shadow-xl overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Order Details</h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-1">
                        <h4 class="text-xl font-bold text-gray-900">Order #{{ $orderId }}</h4>
                        <div>
                            @if($status === 'completed')
                                <span class="px-3 py-1 inline-flex text-sm font-medium rounded-full bg-green-50 text-green-700">Completed</span>
                            @elseif($status === 'processing')
                                <span class="px-3 py-1 inline-flex text-sm font-medium rounded-full bg-blue-50 text-blue-700">Processing</span>
                            @elseif($status === 'pending')
                                <span class="px-3 py-1 inline-flex text-sm font-medium rounded-full bg-yellow-50 text-yellow-700">Pending</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm font-medium rounded-full bg-red-50 text-red-700">{{ ucfirst($status) }}</span>
                            @endif
                        </div>
                    </div>
                    <p class="text-sm text-gray-500">{{ $orderDate }}</p>
                </div>
                
                <div class="mb-6">
                    <h5 class="text-sm font-medium text-gray-500 uppercase mb-3">Customer Information</h5>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800 font-medium">{{ $customerName }}</p>
                        <p class="text-gray-600 text-sm">{{ $customerEmail }}</p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h5 class="text-sm font-medium text-gray-500 uppercase mb-3">Order Summary</h5>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-800 font-medium">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Tax</span>
                            <span class="text-gray-800 font-medium">${{ number_format($total - $subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-800 font-bold">Total</span>
                            <span class="text-gray-900 font-bold">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h5 class="text-sm font-medium text-gray-500 uppercase mb-3">Update Status</h5>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <select wire:model="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 mt-8">
                    <button wire:click="closeModal" class="px-6 py-2.5 bg-gray-200 rounded-md text-base font-medium text-gray-700 hover:bg-gray-300 focus:outline-none transition-colors duration-200 inline-block min-w-[100px] text-center" style="padding-top: 0.6rem; padding-bottom: 0.6rem;">
                        Close
                    </button>
                    <button wire:click="updateStatus" class="px-6 rounded-md text-base font-medium text-white focus:outline-none transition-colors duration-200 min-w-[140px]" style="background-color: #e63946; border: none; padding-top: 0.6rem; padding-bottom: 0.6rem;" onmouseover="this.style.backgroundColor='#c1121f'" onmouseout="this.style.backgroundColor='#e63946'">
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
