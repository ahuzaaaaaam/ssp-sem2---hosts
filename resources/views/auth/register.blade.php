<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <x-label for="first_name" value="{{ __('First Name') }}" class="text-gray-700 font-medium" />
                <div class="mt-1">
                    <x-input id="first_name" class="block w-full px-4 py-3 border-gray-300 rounded-lg focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition duration-150" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" placeholder="First name" />
                </div>
            </div>

            <div>
                <x-label for="last_name" value="{{ __('Last Name') }}" class="text-gray-700 font-medium" />
                <div class="mt-1">
                    <x-input id="last_name" class="block w-full px-4 py-3 border-gray-300 rounded-lg focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition duration-150" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" placeholder="Last name" />
                </div>
            </div>

            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-medium" />
                <div class="mt-1">
                    <x-input id="email" class="block w-full px-4 py-3 border-gray-300 rounded-lg focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition duration-150" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
                </div>
            </div>

            <div>
                <x-label for="phone" value="{{ __('Phone Number') }}" class="text-gray-700 font-medium" />
                <div class="mt-1">
                    <x-input id="phone" class="block w-full px-4 py-3 border-gray-300 rounded-lg focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition duration-150" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="1234567890" />
                </div>
            </div>

            <div>
                <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-medium" />
                <div class="mt-1">
                    <x-input id="password" class="block w-full px-4 py-3 border-gray-300 rounded-lg focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition duration-150" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                </div>
            </div>

            <div>
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-gray-700 font-medium" />
                <div class="mt-1">
                    <x-input id="password_confirmation" class="block w-full px-4 py-3 border-gray-300 rounded-lg focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition duration-150" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="mt-6">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                    {{ __('Create Account') }}
                </button>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-medium text-red-600 hover:text-red-800">Sign in</a>
                </p>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
