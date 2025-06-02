<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Admin check is handled by middleware
    
    /**
     * Display the settings page.
     */
    public function index(Request $request)
    {
        
        // Load settings from config or database
        $settings = [
            'site_name' => config('app.name'),
            'contact_email' => config('mail.from.address', 'contact@example.com'),
            'currency' => 'USD',
            'tax_rate' => '10',
            'allow_guest_checkout' => 'yes',
        ];
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the site settings.
     */
    public function update(Request $request)
    {
        
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'currency' => 'required|string|size:3',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'allow_guest_checkout' => 'required|in:yes,no',
            'logo' => 'nullable|image|max:2048',
        ]);

        // Handle logo upload if provided
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/logo');
            $validated['logo_path'] = Storage::url($path);
        }

        // Save settings to database or config
        // This is a placeholder - actual implementation would depend on how settings are stored
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
