<x-guest-layout>

        <!-- Left Column (Password Reset Request Form) -->
        <div class="bg-white p-10 rounded-3xl shadow-2xl col-span-8 md:col-span-1">

            <!-- Logo (optional) -->
            {{-- <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logoamtis.jpg') }}" alt="Logo" class="w-50 h-16">
            </div> --}}

            <!-- Heading -->
            <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Forgot Your Password?</h2>

            <!-- Info Text -->
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Remembered your password?') }}
                    </a>

                    <x-primary-button class="">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>

        </div>

</x-guest-layout>
