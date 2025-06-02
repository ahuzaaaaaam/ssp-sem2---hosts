<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-medium" />
                <div class="mt-1">
                    <x-input id="email" class="block w-full px-4 py-3 border-gray-300 rounded-lg focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition duration-150" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-medium" />
                </div>
                <div class="mt-1">
                    <x-input id="password" class="block w-full px-4 py-3 border-gray-300 rounded-lg focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition duration-150" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                </div>
            </div>

            <div class="flex items-center">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" class="text-red-600 focus:ring-red-500" />
                    <span class="ms-2 text-sm text-gray-700">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                    {{ __('Sign in') }}
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-800">Sign up</a>
                </p>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
