<x-app-layout>
    @section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="text-center my-4" style="font-size: 2em; font-weight: bold;">QR Code Attendance</h1>
                
                <!-- Timer display -->
                <div class="my-2 text-center">
                    <p class="fs-6">
                        Next refresh in <span id="countdown-timer" class="fw-bold">5</span> seconds.
                    </p>
                </div>

                <!-- QR Code display container -->
                <div id="qr-code" class="qr-code-container mx-auto d-flex justify-content-center align-items-center my-4">
                    {!! $qrCode !!}
                </div>

                <!-- OTP display -->
                <p class="text-center mt-4 fs-5 fw-semibold">
                    OTP: <span id="otp-display" class="text-primary">{{ $otp }}</span>
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let countdown = 15; // Initialize countdown timer

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
                countdown = 15;
                document.getElementById('countdown-timer').innerText = countdown;

                // Restart the countdown
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
            padding: 10px;
            border: 5px solid #000; /* Black border around the QR code */
            border-radius: 10px; /* Optional: rounded corners */
            max-width: 250px;
            max-height: 250px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 1.5em;
            }

            .qr-code-container {
                max-width: 200px;
                max-height: 200px;
            }

            p {
                font-size: 0.9em;
            }
        }

        @media (min-width: 768px) and (max-width: 992px) {
            h1 {
                font-size: 1.8em;
            }

            p {
                font-size: 1em;
            }
        }
    </style>
</x-app-layout>
