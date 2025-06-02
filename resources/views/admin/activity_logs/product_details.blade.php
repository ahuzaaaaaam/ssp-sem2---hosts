@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header with Back Button -->
        <div class="bg-gray-50 py-6 px-4 mb-8 rounded-lg">
            <div class="flex flex-col space-y-2">
                <a href="{{ route('admin.activity-logs.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to All Logs
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Product #{{ $productId }} Activities</h1>
                <p class="text-sm text-gray-600">All user activities related to this product</p>
            </div>
        </div>

        <!-- Activity Logs Table Section -->


        <!-- Activity Logs Table -->
        <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200 mb-8">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Activity History</h2>
                <div class="overflow-x-auto min-h-[340px] flex flex-col justify-between">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DATE & TIME</th>
                                <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIVITY</th>
                                <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">USER</th>
                                <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">IP ADDRESS</th>
                                <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">DEVICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $rowCount = 0; @endphp
                            @foreach($logs as $log)
                                @php $rowCount++; @endphp
                                <tr class="{{ $rowCount % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="py-4 px-2 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y H:i:s') }}
                                    </td>
                                    <td class="py-4 px-2 text-center">
                                        @switch($log->activity)
                                            @case('login')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Login</span>
                                                @break
                                            @case('logout')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Logout</span>
                                                @break
                                            @case('view')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Product View</span>
                                                @break
                                            @case('add_to_cart')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Add to Cart</span>
                                                @break
                                            @case('purchase')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">Purchase</span>
                                                @break
                                            @case('page_visit')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Page Visit</span>
                                                @break
                                            @default
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">{{ ucfirst($log->activity ?? 'Unknown') }}</span>
                                        @endswitch
                                    </td>
                                    <td class="py-4 px-2 text-center text-sm text-gray-700">
                                        @if($log->user_id)
                                            User #{{ $log->user_id }}
                                        @else
                                            Guest
                                        @endif
                                    </td>
                                    <td class="py-4 px-2 text-center text-sm text-gray-500">
                                        {{ $log->ip }}
                                    </td>
                                    <td class="py-4 px-2 text-center text-sm text-gray-500">
                                        <span class="truncate max-w-xs block" title="{{ $log->user_agent }}">
                                            {{ \Illuminate\Support\Str::limit($log->user_agent, 30) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            @for($i = $rowCount; $i < 8; $i++)
                                <tr class="{{ ($i+1) % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="py-4 px-2">&nbsp;</td>
                                    <td class="py-4 px-2">&nbsp;</td>
                                    <td class="py-4 px-2">&nbsp;</td>
                                    <td class="py-4 px-2">&nbsp;</td>
                                    <td class="py-4 px-2">&nbsp;</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
