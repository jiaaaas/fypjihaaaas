<x-guest-layout>
        <!-- Left Column (Password Confirmation Instruction) -->
        <div class="bg-white p-10 rounded-3xl shadow-2xl col-span-8 md:col-span-1">

            <!-- Logo (optional) -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logoamtis.jpg') }}" alt="Logo" class="w-50 h-16">
            </div>

            <!-- Heading -->
            <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">{{ __('Confirm Your Password') }}</h2>

            <!-- Instruction Text -->
            <div class="mb-4 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <!-- Password Confirmation Form -->
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password Input -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-4">
                    <x-primary-button>
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
</x-guest-layout>
