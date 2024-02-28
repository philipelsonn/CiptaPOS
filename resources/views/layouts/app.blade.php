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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <div class="d-flex">
                <!-- Sidebar -->
                <div class="d-flex flex-column flex-shrink-0 text-bg-dark" style="width: 280px; height: 100vh">
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white mt-2 ml-3" aria-current="page">
                                Products
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white mt-2 ml-3">
                                History
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white mt-2 ml-3">
                                Suppliers
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white mt-2 ml-3">
                                Employees
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white mt-2 ml-3">
                                Profile
                            </a>
                        </li>
                    </ul>
                    <hr>
                </div>

                <!-- Main Content -->
                <main class="flex-grow-1">
                    {{ $slot }}
                </main>
            </div>

    </body>
</html>
