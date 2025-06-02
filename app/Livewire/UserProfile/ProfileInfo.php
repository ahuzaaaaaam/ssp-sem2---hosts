<?php

namespace App\Livewire\UserProfile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileInfo extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    
    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
    ];
    
    protected $validationAttributes = [
        'first_name' => 'first name',
        'last_name' => 'last name',
    ];
    
    public function mount()
    {
        $user = Auth::user();
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }
    
    public function updateProfile()
    {
        $this->validate();
        
        $user = Auth::user();
        
        // Check if email is changed and validate uniqueness
        if ($this->email !== $user->email) {
            $this->validate([
                'email' => 'required|email|max:255|unique:users,email',
            ]);
        }
        
        $user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
        
        session()->flash('message', 'Profile updated successfully!');
    }
    
    public function render()
    {
        return view('livewire.user-profile.profile-info');
    }
}
