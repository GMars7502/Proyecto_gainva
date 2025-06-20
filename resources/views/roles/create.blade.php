<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-gray-800">
            Crear Nuevo Rol
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <!-- Nombre del rol -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Nombre del Rol</label>
                        <input type="text" name="name" id="name"
                               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                               value="{{ old('name') }}" placeholder="Ej: Admin">
                    </div>

                    <!-- Permisos -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Selecciona Permisos</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            @foreach($permisos as $permiso)
                                <label class="flex items-center space-x-2 bg-gray-100 px-3 py-2 rounded-md">
                                    <input type="checkbox" name="permissions[]" value="{{ $permiso->id }}"
                                           class="form-checkbox text-blue-600"
                                           {{ in_array($permiso->id, old('permissions', [])) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-800">{{ $permiso->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('roles.index') }}"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
