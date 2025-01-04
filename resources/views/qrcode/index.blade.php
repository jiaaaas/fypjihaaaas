<x-app-layout>
    @section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center my-4" style="font-size: 2em; font-weight: bold;">QR Code Attendance</h1>
                {{-- Timer display --}}
                <div class="my-1 text-center">
                    <p>
                        Next refresh in <span id="countdown-timer">5</span> seconds.
                    </p>
                </div>

                {{-- Container to display QR Code with border --}}
                <div id="qr-code" class="qr-code-container">
                    {!! $qrCode !!}
                </div>

                {{-- OTP display --}}
                <p class="text-center mt-4" style="font-size: 1.2em;">
                    OTP: <span id="otp-display">{{ $otp }}</span>
                </p>
                
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    let countdown = 5; // Initialize countdown timer

    // Function to fetch and regenerate QR Code
    async function regenerateQRCode() {
        try {
            // Fetch new QR code and OTP from the server
            const response = await fetch('{{ route('qrcode.regenerate') }}');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();

            // Update the QR code and OTP on the page
            document.getElementById('qr-code').innerHTML = data.qrCode;
            document.getElementById('otp-display').innerText = data.otp;

            // Reset the countdown timer
            countdown = 5;
            document.getElementById('countdown-timer').innerText = countdown;

            // Start the countdown timer again after QR regeneration
            startCountdown();

        } catch (error) {
            console.error('Error regenerating QR code:', error);
        }
    }

    // Function to update the countdown timer
    function updateCountdown() {
        if (countdown > 0) {
            countdown--; // Decrease the countdown
            document.getElementById('countdown-timer').innerText = countdown;
        } else {
            regenerateQRCode(); // Regenerate QR code when countdown reaches 0
        }
    }

    // Start the countdown timer
    function startCountdown() {
        // Clear any previous intervals to prevent multiple intervals running at once
        clearInterval(window.countdownInterval);

        // Start the countdown at an interval of 1 second
        window.countdownInterval = setInterval(updateCountdown, 1000);
    }

    // Start countdown when the page loads
    startCountdown();

    </script>
    @endpush

    @endsection

    <style>
        .qr-code-container {
            display: inline-block;
            padding: 10px;
            border: 5px solid #000; /* Black border around the QR code */
            border-radius: 10px; /* Optional: rounded corners */
        }
    </style>
</x-app-layout>