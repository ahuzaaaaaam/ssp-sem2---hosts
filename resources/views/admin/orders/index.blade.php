@extends('layouts.app')

@section('styles')
    @livewireStyles
@endsection

@section('content')
    @livewire('admin.order-manager')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <h1 class="text-2xl font-bold text-gray-800 mb-6">Order Management</h1>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mb-8">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">All Orders</h3>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full rounded-lg shadow-md overflow-hidden">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                    <tbody class="bg-white">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-all duration-200 border-b border-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center">
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
                                <td class="px-6 py-4 text-center">
                                    <a href="javascript:void(0)" onclick="openOrderModalLivewire({{ $order->id }})" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center">
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No orders yet</h3>
                                        <p class="mt-1 text-sm text-gray-500">New orders will appear here once customers start placing them.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6 px-6 pb-6">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Order modal is now handled by the Livewire component -->

@endsection

@section('scripts')
    @livewireScripts
    <script>
        // This function will now trigger the Livewire component
        function openOrderModalLivewire(orderId) {
            Livewire.dispatch('openOrderModal', { orderId: orderId });
        }
        
        // Check URL for order parameter and open modal if present
        document.addEventListener('livewire:initialized', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const orderId = urlParams.get('order');
            if (orderId) {
                openOrderModalLivewire(orderId);
                
                // Listen for modal close event and remove the order parameter from URL
                Livewire.on('orderModalClosed', () => {
                    // Remove the order parameter from URL without refreshing the page
                    const url = new URL(window.location.href);
                    url.searchParams.delete('order');
                    window.history.replaceState({}, '', url);
                });
            }
        });
    </script>
@endsection
