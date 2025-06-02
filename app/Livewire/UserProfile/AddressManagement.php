<?php

namespace App\Livewire\UserProfile;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddressManagement extends Component
{
    public $addresses = [];
    public $showAddressForm = false;
    public $editingAddressId = null;
    
    // Address form fields
    public $address_line1;
    public $address_line2;
    public $city;
    public $state;
    public $postal_code;
    public $is_default = false;
    
    protected $rules = [
        'address_line1' => 'required|string|max:255',
        'address_line2' => 'nullable|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'postal_code' => 'required|string|max:20',
        'is_default' => 'boolean',
    ];
    
    public function mount()
    {
        $this->loadAddresses();
    }
    
    public function loadAddresses()
    {
        $this->addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
    }
    
    public function showForm()
    {
        $this->resetForm();
        $this->showAddressForm = true;
    }
    
    public function hideForm()
    {
        $this->showAddressForm = false;
        $this->resetForm();
    }
    
    public function resetForm()
    {
        $this->reset([
            'address_line1', 'address_line2', 'city', 'state', 'postal_code', 'is_default', 'editingAddressId'
        ]);
    }
    
    public function editAddress($addressId)
    {
        $address = Auth::user()->addresses()->findOrFail($addressId);
        
        $this->editingAddressId = $address->id;
        $this->address_line1 = $address->address_line1;
        $this->address_line2 = $address->address_line2;
        $this->city = $address->city;
        $this->state = $address->state;
        $this->postal_code = $address->postal_code;
        $this->is_default = $address->is_default;
        
        $this->showAddressForm = true;
    }
    
    public function saveAddress()
    {
        $this->validate();
        
        $user = Auth::user();
        
        if ($this->is_default) {
            // Set all other addresses as non-default
            $user->addresses()->update(['is_default' => false]);
        } else if ($this->editingAddressId === null && $user->addresses()->count() === 0) {
            // If this is the first address, make it default
            $this->is_default = true;
        }
        
        if ($this->editingAddressId) {
            // Update existing address
            $address = $user->addresses()->findOrFail($this->editingAddressId);
            $address->update([
                'address_line1' => $this->address_line1,
                'address_line2' => $this->address_line2,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'is_default' => $this->is_default,
            ]);
            
            session()->flash('message', 'Address updated successfully!');
        } else {
            // Create new address
            $user->addresses()->create([
                'address_line1' => $this->address_line1,
                'address_line2' => $this->address_line2,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'is_default' => $this->is_default,
            ]);
            
            session()->flash('message', 'Address added successfully!');
        }
        
        $this->hideForm();
        $this->loadAddresses();
    }
    
    public function deleteAddress($addressId)
    {
        $address = Auth::user()->addresses()->findOrFail($addressId);
        
        // If deleting default address, make another one default if available
        if ($address->is_default) {
            $newDefault = Auth::user()->addresses()->where('id', '!=', $addressId)->first();
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }
        
        $address->delete();
        session()->flash('message', 'Address deleted successfully!');
        
        $this->loadAddresses();
    }
    
    public function setDefaultAddress($addressId)
    {
        // Set all addresses as non-default
        Auth::user()->addresses()->update(['is_default' => false]);
        
        // Set the selected address as default
        $address = Auth::user()->addresses()->findOrFail($addressId);
        $address->update(['is_default' => true]);
        
        session()->flash('message', 'Default address updated successfully!');
        
        $this->loadAddresses();
    }
    
    public function render()
    {
        return view('livewire.user-profile.address-management');
    }
}
