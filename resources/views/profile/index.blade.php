@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center mb-8">
        <div class="flex-shrink-0 mr-6">
            <div class="h-24 w-24 rounded-full bg-red-600 flex items-center justify-center text-white text-2xl font-bold">
                {{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}
            </div>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
            <p class="text-gray-600">{{ Auth::user()->email }}</p>
            <p class="text-gray-600">Member since {{ Auth::user()->created_at->format('F Y') }}</p>
        </div>
    </div>
    
    <div x-data="{ activeTab: 'profile' }" class="mb-8">
        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'profile'" :class="{'border-red-500 text-red-600': activeTab === 'profile', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'profile'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Profile Information
                </button>
                <button @click="activeTab = 'orders'" :class="{'border-red-500 text-red-600': activeTab === 'orders', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'orders'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Order History
                </button>
                <button @click="activeTab = 'addresses'" :class="{'border-red-500 text-red-600': activeTab === 'addresses', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'addresses'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Addresses
                </button>
                <button @click="activeTab = 'password'" :class="{'border-red-500 text-red-600': activeTab === 'password', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'password'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Change Password
                </button>
            </nav>
        </div>
        
        <!-- Tab Content -->
        <div x-show="activeTab === 'profile'">
            @livewire('user-profile.profile-info')
        </div>
        
        <div x-show="activeTab === 'orders'">
            @livewire('user-profile.order-history')
        </div>
        
        <div x-show="activeTab === 'addresses'">
            @livewire('user-profile.address-management')
        </div>
        
        <div x-show="activeTab === 'password'">
            @livewire('user-profile.change-password')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endpush
