<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Store Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Store Configuration</h3>
                    </div>

                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Site Name -->
                            <div>
                                <x-label for="site_name" value="{{ __('Site Name') }}" />
                                <x-input id="site_name" class="block mt-1 w-full" type="text" name="site_name" :value="$settings['site_name']" required />
                            </div>

                            <!-- Contact Email -->
                            <div>
                                <x-label for="contact_email" value="{{ __('Contact Email') }}" />
                                <x-input id="contact_email" class="block mt-1 w-full" type="email" name="contact_email" :value="$settings['contact_email']" required />
                            </div>

                            <!-- Currency -->
                            <div>
                                <x-label for="currency" value="{{ __('Currency Code') }}" />
                                <x-input id="currency" class="block mt-1 w-full" type="text" name="currency" :value="$settings['currency']" required />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">3-letter currency code (e.g., USD, EUR, GBP)</p>
                            </div>

                            <!-- Tax Rate -->
                            <div>
                                <x-label for="tax_rate" value="{{ __('Tax Rate (%)') }}" />
                                <x-input id="tax_rate" class="block mt-1 w-full" type="number" name="tax_rate" min="0" max="100" step="0.01" :value="$settings['tax_rate']" required />
                            </div>

                            <!-- Allow Guest Checkout -->
                            <div>
                                <x-label for="allow_guest_checkout" value="{{ __('Allow Guest Checkout') }}" />
                                <select id="allow_guest_checkout" name="allow_guest_checkout" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="yes" {{ $settings['allow_guest_checkout'] == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ $settings['allow_guest_checkout'] == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <!-- Logo Upload -->
                            <div class="md:col-span-2">
                                <x-label for="logo" value="{{ __('Store Logo') }}" />
                                <input id="logo" type="file" name="logo" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    dark:file:bg-indigo-900 dark:file:text-indigo-300
                                    hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload a new logo (optional)</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-button class="ml-4">
                                {{ __('Save Settings') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
