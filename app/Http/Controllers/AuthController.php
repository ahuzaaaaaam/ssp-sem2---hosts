<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $user = User::where('email', $credentials['email'])->first();
        
        if ($user && \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            // Login successful
            Auth::login($user);
            
            // Redirect admin users to the admin dashboard
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->intended('/');
        }
        
        // Login failed
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput($request->except('password'));
    }
    
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/(@gmail\.com$|@yahoo\.com$|@outlook\.com$)/'
            ],
            'phone' => 'required|digits:9',
            'password' => 'required|string|min:3|confirmed',
        ], [
            'email.regex' => 'Invalid email format. Use a valid domain like gmail.com.',
            'phone.digits' => 'Phone number must be exactly 9 digits.',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Add +94 prefix to the phone number
        $phone = '+94' . $request->phone;
        
        // Create user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $phone,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'user',
        ]);
        
        // Login the user
        Auth::login($user);
        
        return redirect('/')->with('success', 'Registration successful!');
    }
    
    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
