<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Staff Management System with Performance Report Generator</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
        </style>
    @endif
</head>
<body class="font-sans antialiased" style="background-color: #E9EFEC;">
    <div class="bg-gray-50 text-black min-h-screen flex flex-col" style="background-color: #E9EFEC;">
        <!-- Header -->
        <header class="shadow py-4" style="background-color: #265073;">
            <div class="container mx-auto px-4 flex flex-wrap justify-between items-center">
                <div class="flex-1 text-left">
                    <h1 class="text-2xl py-2 px-4 text-white">SMPR</h1>
                </div>
                @if (Route::has('login'))
                    <nav class="flex flex-wrap space-x-4 ml-auto text-white text-sm">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="hover:text-yellow-600 py-2 px-4 rounded">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-yellow-600 py-1 px-4 rounded">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="hover:text-yellow-600 py-1 px-4 rounded">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="mt-6 flex-grow">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl py-4 px-6 text-black break-words mt-10">Staff Management System with Performance Report Generator</h1>
                
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/logoamtis.jpg') }}" alt="AMTIS SOLUTION" class="img-fluid max-w-full"> 
                </div>
                
                <div id="clock" class="clock text-7xl font-semibold"></div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-4 text-center">
            <small>HAK CIPTA &copy; 2024 AMTIS SOLUTION SDN. BHD</small>
        </footer>
    </div>

    <script>
        // Clock in 12-hour format
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';

            // Convert hours from 24-hour to 12-hour format
            hours = hours % 12;
            hours = hours ? hours : 12; // The hour '0' should be '12'
            hours = String(hours).padStart(2, '0');

            // Update the clock display
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds} ${ampm}`;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>
