<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <div class="d-flex">
                <!-- Sidebar -->
                <div class="flex-shrink-0 bg-dark text-white" style="width: 280px;">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white mt-7 ml-4" style="font-size: 20px;">
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white mt-7 ml-4" style="font-size: 20px;">
                                History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white mt-7 ml-4"  style="font-size: 20px;">
                                Suppliers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white mt-7 ml-4" style="font-size: 20px;">
                                <h1> Employees </h1>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white mt-7 ml-4" style="font-size: 20px;">
                                Profile
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Main Content -->
                <main class="flex-grow-1">
                    {{ $slot }}
                </main>
            </div>


    </body>
</html>
