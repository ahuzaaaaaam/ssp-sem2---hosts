<div class="p-6" x-data="{}" @edit-product.window="$wire.edit($event.detail.id);">
    <!-- Search and Buttons on Same Line -->
    <div class="flex items-center space-x-4 mb-6">
        <div class="flex-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search for products..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 text-gray-700">
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-md flex items-center justify-center whitespace-nowrap transition-all duration-200">
            Back to Dashboard
        </a>
        <button wire:click="openModal" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-md flex items-center justify-center whitespace-nowrap transition-colors duration-200">
            Add Product
        </button>
    </div>
    
    @if (session()->has('success'))
        <div class="mb-6">
            <div class="flex items-center p-4 rounded-lg shadow-sm bg-orange-50 border border-orange-200" style="width: 19rem;" role="alert">
                <div class="flex-shrink-0 mr-3">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-orange-700">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="ml-auto -mx-1.5 -my-1.5 bg-orange-50 text-orange-400 hover:text-orange-700 rounded-lg p-1.5 inline-flex h-8 w-8 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif
    
    <!-- All Products Header with Sorting Options -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">All Products</h3>
            <div class="flex space-x-4">
                <button wire:click="sortBy('name')" class="text-sm font-medium {{ $sortField === 'name' ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' }} transition-colors duration-150">
                    Name {{ $sortField === 'name' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                </button>
                <button wire:click="sortBy('price')" class="text-sm font-medium {{ $sortField === 'price' ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' }} transition-colors duration-150">
                    Price {{ $sortField === 'price' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                </button>
                <button wire:click="sortBy('created_at')" class="text-sm font-medium {{ $sortField === 'created_at' ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' }} transition-colors duration-150">
                    Newest {{ $sortField === 'created_at' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                </button>
            </div>
        </div>
        
        <div class="p-6">
            @if(count($products) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white border border-gray-100 rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow duration-200">
                            <div class="flex items-center">
                                <!-- Product Image - Fixed Square -->
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
                                
                                <!-- Product Details -->
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900">{{ $product->name }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($product->description, 60) }}</p>
                                        </div>
                                        <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    
                                    <div class="mt-3 flex items-center justify-between">
                                        <div class="flex space-x-2">
                                            <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full {{ $product->veg === 'Yes' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->veg === 'Yes' ? 'Vegetarian' : 'Non-Veg' }}
                                            </span>
                                            @if($product->featured === 'Yes')
                                                <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Featured
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2">
                                            <button wire:click="edit({{ $product->id }})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                Edit
                                            </button>
                                            <button wire:click="confirmDelete({{ $product->id }})" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 border-t border-gray-200 pt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No products</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new product.</p>
                    <div class="mt-6">
                        <button wire:click="openModal" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Product
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Product Modal -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{}" x-show="$wire.showModal" x-cloak>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" x-show="$wire.showModal">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" x-show="$wire.showModal">
                <div class="bg-white px-6 pt-6 pb-6 sm:p-6 sm:pb-6">
                    <form wire:submit.prevent="{{ $editMode ? 'update' : 'create' }}">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-900">{{ $editMode ? 'Edit Product' : 'Add New Product' }}</h3>
                        </div>
                        
                        <!-- Name and Price Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" style="display: block; text-align: left;" class="text-gray-700 mb-2 text-sm font-medium">Product Name</label>
                                <input type="text" id="name" wire:model="name" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500">
                                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="price" style="display: block; text-align: left;" class="text-gray-700 mb-2 text-sm font-medium">Price</label>
                                <input type="number" id="price" wire:model="price" step="0.01" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500">
                                @error('price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <!-- Description Full Width -->
                        <div class="mb-6">
                            <label for="description" style="display: block; text-align: left;" class="text-gray-700 mb-2 text-sm font-medium">Description</label>
                            <textarea id="description" wire:model="description" rows="3" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"></textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Image Upload and URL Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label style="display: block; text-align: left;" class="text-gray-700 mb-2 text-sm font-medium">Product Image</label>
                                <div>
                                    <label for="image" class="block w-full py-2 px-4 border border-gray-300 rounded-md cursor-pointer bg-gray-50 text-gray-700">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Choose File
                                        </span>
                                        <input type="file" id="image" wire:model="image" class="hidden">
                                    </label>
                                    <div wire:loading wire:target="image" class="text-sm text-gray-500 mt-1">Uploading...</div>
                                    @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="image_url" style="display: block; text-align: left;" class="text-gray-700 mb-2 text-sm font-medium">Image URL</label>
                                <input type="text" id="image_url" wire:model="image_url" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500">
                                @error('image_url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <!-- Vegetarian and Featured Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="veg" style="display: block; text-align: left;" class="text-gray-700 mb-2 text-sm font-medium">Vegetarian</label>
                                <select id="veg" wire:model="veg" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                @error('veg') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="featured" style="display: block; text-align: left;" class="text-gray-700 mb-2 text-sm font-medium">Featured Product</label>
                                <select id="featured" wire:model="featured" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                @error('featured') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col space-y-3 mt-6">
                            <button type="submit" class="w-full py-3 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-md">
                                {{ $editMode ? 'Update Product' : 'Create Product' }}
                            </button>
                            <button type="button" wire:click="closeModal" class="w-full py-3 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 font-medium shadow-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: false }" x-show="show" x-cloak
         x-on:confirm-delete.window="show = true" x-on:product-deleted.window="show = false">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" x-show="show">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" x-show="show">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Delete Product
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this product? This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-between gap-4">
                    <button type="button" @click="show = false" class="flex-1 justify-center rounded-md border border-gray-300 px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 sm:text-sm transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="button" wire:click="delete" class="flex-1 justify-center rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 sm:text-sm transition-colors duration-200">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
