<aside class="w-64 bg-green-900 text-white min-h-screen flex flex-col">
    <div class="flex items-center justify-center h-20 border-b border-green-700">
        <img src="{{ asset('assets/images/ico_logo.ico') }}" alt="Logo" class="h-12">
    </div>
    <nav class="flex-1 px-4 py-2 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('dashboard') ? 'bg-green-800' : '' }}">
            Dashboard
        </a>
        
        @can('almacen.index')
        <a href="{{ route('almacen.index') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('almacen.*') ? 'bg-green-800' : '' }}">
            Almacén
        </a>
        @endcan
        
        @can('petitorio.index')
        <a href="{{ route('petitorio.index') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('petitorio.*') ? 'bg-green-800' : '' }}">
            Petitorio
        </a>
        @endcan

        @can('control_cebado.index')
        <a href="{{ route('control_cebado.index') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('control_cebado.*') ? 'bg-green-800' : '' }}">
            Control Cebado
        </a>
        @endcan
        
        @can('inventario.index')
        <a href="{{ route('inventario.index') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('inventario.*') ? 'bg-green-800' : '' }}">
            Inventario
        </a>
        @endcan

        <hr></hr>

        @can('users.index')
        <a href="{{ route('users.index') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('users.*') ? 'bg-green-800' : '' }}">
            Usuarios
        </a>
        @endcan

        @can('permisos.index')
        <a href="{{ route('permisos.index') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('permisos.*') ? 'bg-green-800' : '' }}">
            Permisos
        </a>
        @endcan

        @can('role.index')
        <a href="{{ route('roles.index') }}" class="block px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('roles.*') ? 'bg-green-800' : '' }}">
            Roles
        </a>
        @endcan
    </nav>
</aside>
