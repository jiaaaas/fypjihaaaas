<x-guest-layout>
    {{-- <div class="bg-gray-50 min-h-screen flex justify-center items-center"> --}}

    <!-- Container with two columns in a row -->
    <div class="w-full gap-8 mx-auto">

        <!-- Left Column (Login Form) -->
        <div class="bg-white p-10 rounded-3xl shadow-2xl">

            <!-- Logo (optional) -->
            <div class="flex justify-center mb-6">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logoamtis.jpg') }}" alt="Logo" class="w-50 h-16">
                </a>
            </div>

            <!-- Heading -->
            <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Login to Your Account</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-sm text-gray-600" />
                    <x-text-input id="email" class="block mt-2 w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition-all duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-sm text-gray-600" />
                    <x-text-input id="password" class="block mt-2 w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition-all duration-200"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center text-sm text-gray-600">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Action buttons -->
                <div class="flex items-center justify-between mt-6">
                    <div class="text-sm">
                        @if (Route::has('password.request'))
                            <a class="text-indigo-600 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <x-primary-button class="ml-3 bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

        </div>        
        
    </div>
    {{-- </div> --}}

</x-guest-layout>
