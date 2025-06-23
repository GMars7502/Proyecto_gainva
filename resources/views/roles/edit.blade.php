<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Editar Rol</h1>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-medium text-sm text-gray-700">Nombre del Rol:</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', $role->name) }}"
                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                    required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700 mb-2">Permisos:</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($permissions as $permission)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                class="form-checkbox text-indigo-600">
                            <span class="ml-2">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('roles.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded mr-2">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
