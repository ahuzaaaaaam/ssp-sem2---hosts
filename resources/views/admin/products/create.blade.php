@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Create New Product') }}</h1>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Back to Products
            </a>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Name -->
                            <div>
                                <x-label for="name" value="{{ __('Product Name') }}" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                @error('name')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div>
                                <x-label for="price" value="{{ __('Price') }}" />
                                <x-input id="price" class="block mt-1 w-full" type="number" name="price" step="0.01" min="0" :value="old('price')" required />
                                @error('price')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-label for="description" value="{{ __('Description') }}" />
                                <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <x-label for="image" value="{{ __('Product Image') }}" />
                                <input id="image" type="file" name="image" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    dark:file:bg-indigo-900 dark:file:text-indigo-300
                                    hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800" />
                                @error('image')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image URL (Alternative) -->
                            <div>
                                <x-label for="image_url" value="{{ __('Image URL (Optional)') }}" />
                                <x-input id="image_url" class="block mt-1 w-full" type="url" name="image_url" :value="old('image_url')" placeholder="https://example.com/image.jpg" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">If no image is uploaded, this URL will be used</p>
                                @error('image_url')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Vegetarian Option -->
                            <div>
                                <x-label for="veg" value="{{ __('Vegetarian') }}" />
                                <select id="veg" name="veg" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="Yes" {{ old('veg') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('veg') == 'No' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('veg')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Featured Option -->
                            <div>
                                <x-label for="featured" value="{{ __('Featured Product') }}" />
                                <select id="featured" name="featured" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="Yes" {{ old('featured') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('featured') == 'No' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('featured')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.products.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 mr-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-button>
                                {{ __('Create Product') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
