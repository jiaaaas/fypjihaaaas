{{-- @extends('layouts.app-layout') --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
<!-- Bootstrap CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- Google Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Google Fonts (Roboto) -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>

    body {
        font-family: var(--bs-font-sans-serif);
        background-color: #0c335b;
        color: #343a40;
        font-size: 16px;
        padding-top: 1rem;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; 
    }

    /* Card styles */
    .card {
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 0.75rem;
    }

    /* Header style */
    .navbar {
        background-color: var(--primary-color);
        padding: 1rem;
    }
    .navbar-brand, .nav-link {
        color: #ffffff !important;
    }

    /* Button styles */
    .btn-primary {
        background-color: rgb(0, 187, 0);
        border: none;
    }
    .btn-primary:hover {
        background-color: rgb(6, 106, 6);
    }
    .btn-secondary {
    background-color: #526D82 !important; 
    border: none !important; 
    }

    .btn-secondary:hover {
        background-color: #092846 !important; 
    }

    .btn-warning:hover {
        background-color: #d6a30a;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(74, 144, 226, 0.1);
    }
    .table thead {
        background-color: var(--secondary-color);
        color: #ffffff;
    }
    .title-container {
        text-align: left;
        margin-bottom: 20px;
    }
    .page-title {
        font-size: 25px;
        font-weight: bold;
        color: #000000; 
        padding: 10px;
        border-bottom: 1px solid #000000;
    }
    .btn-sm {
    padding: 0.1rem 0.5rem; /* Reduce the padding */
    font-size: 1rem; /* Adjust the font size */
    }

</style>
@yield('css')


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="background-color: #265073">
        <div class="min-h-screen bg-white-100" style="background-color: #E9EFEC">
            @include('layouts.navigation')
    
            {{-- @yield('header')   --}}
    
            {{-- <main>
                {{ $slot }}
            </main> --}}

            <main>
                {{-- Conditional rendering for $slot --}}
                @if (isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>


            <div class="page-body" style="background-color: #E9EFEC">
                <div class="container-xl">
                    @yield('content')
                </div>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>

<script>
    setTimeout(() => {
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            const alert = new bootstrap.Alert(successMessage);
            alert.close();
        }
    }, 5000); 
</script>

