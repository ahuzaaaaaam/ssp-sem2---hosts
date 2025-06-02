<?php

namespace App\Livewire\UserProfile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    public $current_password;
    public $password;
    public $password_confirmation;
    
    protected $rules = [
        'current_password' => 'required',
        'password' => 'required|min:8|confirmed',
    ];
    
    protected $validationAttributes = [
        'current_password' => 'current password',
        'password' => 'new password',
        'password_confirmation' => 'password confirmation',
    ];
    
    public function updatePassword()
    {
        $this->validate();
        
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
        
        session()->flash('message', 'Password updated successfully!');
    }
    
    public function render()
    {
        return view('livewire.user-profile.change-password');
    }
}
