<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Primary Navigation -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-red-600 font-bold text-xl">Pizza Shop</a>
                </div>
                
                <!-- Primary Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Home
                    </a>
                    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Menu
                    </a>
                    <a href="{{ route('customize.index') }}" class="{{ request()->routeIs('customize.index') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Customize Pizza
                    </a>
                    @if (Auth::check() && Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.products.index') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Admin Dashboard
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- User Navigation -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-3">
                @auth
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative p-1 rounded-full text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <span class="sr-only">View cart</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @if ($cartCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $cartCount }}</span>
                        @endif
                    </a>
                    
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                        <div>
                            <button @click="open = !open" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ Auth::check() ? Auth::user()->first_name : 'Guest' }}+{{ Auth::check() ? Auth::user()->last_name : '' }}&color=7F9CF5&background=EBF4FF" alt="{{ Auth::check() ? Auth::user()->name : 'Guest' }}">
                            </button>
                        </div>
                        
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                             style="display: none;"
                             @click="open = false">
                            
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>
                            
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profile
                            </a>
                            
                            @if (Auth::check() && Auth::user()->isAdmin())
    <div class="block px-4 py-2 text-xs text-gray-400">Admin</div>
    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        Dashboard
    </a>
    <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        Manage Products
    </a>
    <a href="{{ route('api.docs') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        API Documentation
    </a>
@endif
                            
                            <!-- Authentication -->
                            <div class="border-t border-gray-200"></div>
                            
                            <button wire:click="logout" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none">
                                Log Out
                            </button>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Log in</a>
                    <a href="{{ route('register') }}" class="bg-red-600 text-white hover:bg-red-700 px-3 py-2 rounded-md text-sm font-medium">Register</a>
                @endauth
            </div>
            
            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" x-show="!open" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="h-6 w-6" x-show="open" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <!-- Mobile Navigation Menu -->
                <div x-show="open" class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right sm:hidden" style="display: none;">
                    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                        <div class="pt-5 pb-6 px-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <a href="{{ route('home') }}" class="text-red-600 font-bold text-xl">Pizza Shop</a>
                                </div>
                                <div class="-mr-2">
                                    <button @click="open = false" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500">
                                        <span class="sr-only">Close menu</span>
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-6">
                                <nav class="grid gap-y-8">
                                    <a href="{{ route('home') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                                        <span class="ml-3 text-base font-medium text-gray-900">Home</span>
                                    </a>
                                    <a href="{{ route('products.index') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                                        <span class="ml-3 text-base font-medium text-gray-900">Menu</span>
                                    </a>
                                    <a href="{{ route('customize.index') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                                        <span class="ml-3 text-base font-medium text-gray-900">Customize Pizza</span>
                                    </a>
                                    @auth
                                        <a href="{{ route('cart.index') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                                            <span class="ml-3 text-base font-medium text-gray-900">Cart</span>
                                            @if ($cartCount > 0)
                                                <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ $cartCount }}</span>
                                            @endif
                                        </a>
                                        <a href="{{ route('profile') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                                            <span class="ml-3 text-base font-medium text-gray-900">Profile</span>
                                        </a>
                                        <button wire:click="logout" class="w-full text-left -m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                                            <span class="ml-3 text-base font-medium text-gray-900">Log Out</span>
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                                            <span class="ml-3 text-base font-medium text-gray-900">Log in</span>
                                        </a>
                                        <a href="{{ route('register') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                                            <span class="ml-3 text-base font-medium text-gray-900">Register</span>
                                        </a>
                                    @endauth
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
