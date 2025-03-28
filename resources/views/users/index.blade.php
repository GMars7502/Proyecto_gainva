<x-app-layout>
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 1500)" x-show="show"
            class="bg-green-500 text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 1500)" x-show="show"
            class="bg-red-500 text-white p-3 rounded-md mb-4">
            {{ session('error') }}
        </div>
    @endif
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Gestión de Usuarios</h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-6">

                @can('users.create')
                    <div class="mb-4">
                    <a href="{{ route('users.create') }}" 
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
                    + Crear Usuario
                    </a>

                    </div>
                @endcan

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-6 border-b text-left">Nombre</th>
                                <th class="py-3 px-6 border-b text-left">Email</th>
                                <th class="py-3 px-6 border-b text-left">Rol</th>
                                <th class="py-3 px-6 border-b text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-6 border-b">{{ $user->name }}</td>
                                    <td class="py-3 px-6 border-b">{{ $user->email }}</td>
                                    <td class="py-3 px-6 border-b">{{ $user->getRoleNames()->first() }}</td>
                                    <td class="py-3 px-6 border-b flex space-x-2">
                                        @can('users.edit')
                                            <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded text-sm">
                                                Editar
                                            </a>
                                        @endcan

                                        @can('users.delete')
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm">
                                                Eliminar
                                            </button>
                                        </form>

                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
