<x-guest-layout>

        <!-- Left Column (Verification Instructions) -->
        <div class="bg-white p-10 rounded-3xl shadow-2xl col-span-8 md:col-span-1">

            <!-- Logo (optional) -->
            {{-- <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logoamtis.jpg') }}" alt="Logo" class="w-50 h-16">
            </div> --}}

            <!-- Heading -->
            <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">{{ __('Verify Your Email Address') }}</h2>

            <!-- Verification Instructions -->
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            <!-- Status Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-4 flex items-center justify-between">

                <!-- Resend Verification Email Form -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <div>
                        <x-primary-button>
                            {{ __('Resend Verification Email') }}
                        </x-primary-button>
                    </div>
                </form>

                <!-- Log Out Form -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
</x-guest-layout>
