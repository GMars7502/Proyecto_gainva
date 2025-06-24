<aside
    x-cloak
    x-bind:class="sidebarExpanded ? 'w-64' : 'w-20'"
    class="bg-green-900 text-white min-h-screen flex flex-col transition-all duration-300 ease-in-out"
>
    <div class="flex items-center h-20 border-b border-green-700 px-4">
        <img src="{{ asset('assets/images/ico_logo.ico') }}" alt="Logo" class="h-12 flex-shrink-0">
        <span x-show="sidebarExpanded" class="text-xl font-semibold whitespace-nowrap ml-3">Clínica Gainva</span>
    </div>

    <nav class="flex-1 px-2 py-2 space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('dashboard') ? 'bg-green-800' : '' }}">
            <i class="fas fa-home mr-3"></i>
            <span x-show="sidebarExpanded">Dashboard</span>
        </a>

        @can('users.index')
        <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('users.*') ? 'bg-green-800' : '' }}">
            <i class="fas fa-users mr-3"></i>
            <span x-show="sidebarExpanded">Usuarios</span>
        </a>
        @endcan

        @can('almacen.index')
        <a href="{{ route('almacen.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('almacen.*') ? 'bg-green-800' : '' }}">
            <i class="fas fa-warehouse mr-3"></i>
            <span x-show="sidebarExpanded">Almacén</span>
        </a>
        @endcan

        @can('control_cebado.index')
        <a href="{{ route('control_cebado.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('control_cebado.*') ? 'bg-green-800' : '' }}">
            <i class="fas fa-clipboard-list mr-3"></i>
            <span x-show="sidebarExpanded">Control Cebado</span>
        </a>
        @endcan

        @can('inventario.index')
        <a href="{{ route('inventario.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('inventario.*') ? 'bg-green-800' : '' }}">
            <i class="fas fa-boxes mr-3"></i>
            <span x-show="sidebarExpanded">Inventario</span>
        </a>
        @endcan

        @can('permisos.index')
        <a href="{{ route('permisos.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('permisos.*') ? 'bg-green-800' : '' }}">
            <i class="fas fa-unlock-alt mr-3"></i>
            <span x-show="sidebarExpanded">Permisos</span>
        </a>
        @endcan

        @can('role.index')
        <a href="{{ route('roles.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-green-800 {{ request()->routeIs('roles.*') ? 'bg-green-800' : '' }}">
            <i class="fas fa-user-tag mr-3"></i>
            <span x-show="sidebarExpanded">Roles</span>
        </a>
        @endcan
    </nav>
</aside>
