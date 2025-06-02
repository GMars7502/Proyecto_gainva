<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>
        {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Asegúrate de que LivewireStyles esté aquí si usas Livewire en tu dashboard --}}
    @livewireStyles

    <link rel="icon" href="{{ asset('assets/images/ico_logo.ico') }}" type="image/x-icon">
</head>
<body class="flex bg-gray-100 min-h-screen text-gray-900">
    <x-sidebar />

    <div class="flex-1">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                {{-- Contenido de la cabecera (título de la página, etc.) --}}
                @if (isset($header))
                    <div>
                        {{ $header }}
                    </div>
                @else
                    {{-- Este es un título de respaldo si no se define un slot $header --}}
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Dashboard Prueba - tomar tu prueba') }} {{-- Coincide con tu imagen --}}
                    </h2>
                @endif

                {{-- INICIO: Menú desplegable de usuario (marcado en rojo en tu imagen) --}}
                <div class="relative ml-auto" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div> {{-- Muestra el nombre del usuario (por ejemplo, userAdmin2) --}}
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute z-50 mt-2 w-48 rounded-md shadow-lg right-0" {{-- Alineado a la derecha --}}
                         style="display: none;">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white py-1">
                            {{-- Opción "Profile" --}}
                            <a href="/profile" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                {{ __('Profile') }}
                            </a>

                            {{-- Opción "Log Out" --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                   class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- FIN: Menú desplegable de usuario --}}
            </div>
        </header>

        <main class="p-4">
            {{ $slot }}
        </main>
    </div>
    @livewireScripts {{-- Es bueno tener esto aquí si usas Livewire --}}
</body>
</html>