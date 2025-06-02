<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserProfile extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $current_password;
    public $password;
    public $password_confirmation;
    
    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
    ];
    
    protected $validationAttributes = [
        'first_name' => 'first name',
        'last_name' => 'last name',
        'current_password' => 'current password',
        'password' => 'new password',
        'password_confirmation' => 'password confirmation',
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
    
    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        // Verify current password
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The provided password does not match your current password.');
            return;
        }
        
        $user->update([
            'password' => Hash::make($this->password),
        ]);
        
        $this->reset(['current_password', 'password', 'password_confirmation']);
        
        session()->flash('password_message', 'Password updated successfully!');
    }
    
    public function render()
    {
        return view('livewire.user-profile');
    }
}
