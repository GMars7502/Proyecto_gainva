<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="icon" href="{{ asset('assets/images/ico_logo.ico') }}" type="image/x-icon">
</head>
<body x-data="{
        sidebarExpanded: JSON.parse(localStorage.getItem('sidebarExpanded')) ?? true,
    }" 
    x-init="
        $watch('sidebarExpanded', value => localStorage.setItem('sidebarExpanded', JSON.stringify(value)))
    " 
    class="flex bg-gray-100 min-h-screen text-gray-900">

    <x-sidebar />

    <div class="flex-1">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <!-- Botón para toggle del sidebar -->
                <button @click="sidebarExpanded = !sidebarExpanded" class="text-gray-500 hover:text-gray-700 focus:outline-none mr-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                @if (isset($header))
                    <div>
                        {{ $header }}
                    </div>
                @else
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Dashboard Prueba - tomar tu prueba') }}
                    </h2>
                @endif

                <!-- Menú desplegable de usuario -->
                <div class="relative ml-auto" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="open" x-transition class="absolute z-50 mt-2 w-48 rounded-md shadow-lg right-0 bg-white py-1 ring-1 ring-black ring-opacity-5">
                        <a href="/profile" class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Profile') }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-4">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>