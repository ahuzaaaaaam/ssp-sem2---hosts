<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('API Documentation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">API Endpoints</h3>
                    </div>

                    <div class="space-y-8">
                        @foreach($endpoints as $endpoint)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white">{{ $endpoint['name'] }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $endpoint['description'] }}</p>
                            </div>
                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($endpoint['routes'] as $route)
                                <div class="p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="px-2 py-1 text-xs font-medium rounded 
                                            @if($route['method'] == 'GET') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                            @elseif($route['method'] == 'POST') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                            @elseif($route['method'] == 'PUT') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                            @elseif($route['method'] == 'DELETE') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                            @endif mr-2">
                                            {{ $route['method'] }}
                                        </span>
                                        <code class="text-sm text-gray-700 dark:text-gray-300">{{ $route['url'] }}</code>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $route['description'] }}</p>
                                    <div class="mt-2">
                                        <h5 class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Parameters:</h5>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $route['parameters'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
