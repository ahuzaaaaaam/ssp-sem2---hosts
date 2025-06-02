<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Saved Addresses</h2>
            <button wire:click="showForm" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-1"></i> Add New Address
            </button>
        </div>
        
        @if($showAddressForm)
            <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
                <h3 class="text-lg font-medium mb-3">{{ $editingAddressId ? 'Edit Address' : 'Add New Address' }}</h3>
                <form wire:submit.prevent="saveAddress" class="space-y-4">
                    <div>
                        <label for="address_line1" class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                        <input wire:model="address_line1" type="text" id="address_line1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-red-500 focus:border-red-500">
                        @error('address_line1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="address_line2" class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (Optional)</label>
                        <input wire:model="address_line2" type="text" id="address_line2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-red-500 focus:border-red-500">
                        @error('address_line2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input wire:model="city" type="text" id="city" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-red-500 focus:border-red-500">
                            @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                            <input wire:model="state" type="text" id="state" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-red-500 focus:border-red-500">
                            @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                            <input wire:model="postal_code" type="text" id="postal_code" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-red-500 focus:border-red-500">
                            @error('postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <input wire:model="is_default" type="checkbox" id="is_default" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="is_default" class="ml-2 block text-sm text-gray-700">Set as default address</label>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" wire:click="hideForm" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Cancel
                        </button>
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            {{ $editingAddressId ? 'Update Address' : 'Save Address' }}
                        </button>
                    </div>
                </form>
            </div>
        @endif
        
        @if(count($addresses) > 0)
            <div class="space-y-4">
                @foreach($addresses as $address)
                    <div class="border rounded-lg p-4 {{ $address->is_default ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                        <div class="flex justify-between">
                            <div>
                                <p class="font-medium">
                                    {{ $address->address_line1 }}
                                    @if($address->is_default)
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Default
                                        </span>
                                    @endif
                                </p>
                                @if($address->address_line2)
                                    <p class="text-gray-600">{{ $address->address_line2 }}</p>
                                @endif
                                <p class="text-gray-600">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                            </div>
                            <div class="flex space-x-2">
                                @if(!$address->is_default)
                                    <button wire:click="setDefaultAddress({{ $address->id }})" class="text-sm text-gray-600 hover:text-gray-900">
                                        <i class="fas fa-star"></i>
                                        <span class="sr-only">Set as Default</span>
                                    </button>
                                @endif
                                <button wire:click="editAddress({{ $address->id }})" class="text-sm text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-edit"></i>
                                    <span class="sr-only">Edit</span>
                                </button>
                                <button wire:click="deleteAddress({{ $address->id }})" class="text-sm text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this address?')">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="sr-only">Delete</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-red-600 mb-2">
                    <i class="fas fa-map-marker-alt text-5xl"></i>
                </div>
                <p class="text-gray-600 mb-4">You don't have any saved addresses yet.</p>
                <button wire:click="showForm" class="inline-block bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Add Your First Address
                </button>
            </div>
        @endif
    </div>
</div>
