<aside class="w-64 bg-green-900 text-white min-h-screen flex flex-col">
    <div class="flex items-center justify-center h-20 border-b border-green-700">
        <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" class="h-12">
    </div>
    <nav class="flex-1 px-4 py-2 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('dashboard') ? 'bg-green-800' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('users.index') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('users.*') ? 'bg-green-800' : '' }}">
            Usuarios
        </a>
        <a href="{{ route('almacen.index') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('almacen.*') ? 'bg-green-800' : '' }}">
            Almacén
        </a>
        <a href="{{ route('control_cebado.index') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('control_cebado.*') ? 'bg-green-800' : '' }}">
            Control Cebado
        </a>
        <a href="{{ route('inventario.index') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('inventario.*') ? 'bg-green-800' : '' }}">
            Inventario
        </a>
    </nav>
</aside>
