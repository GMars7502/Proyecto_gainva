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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-image: url('assets/images/Hospital.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md bg-white bg-opacity-95 rounded-xl shadow-xl p-6">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" class="w-32 h-32 rounded-full object-cover">
            </div>

            {{ $slot }}
        </div>
    </div>
</body>
</html>
