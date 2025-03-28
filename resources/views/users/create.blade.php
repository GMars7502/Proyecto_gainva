<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-gray-700 mb-4">Crear Usuario</h1>

        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="name" class="w-full mt-1 p-2 border rounded-md focus:ring focus:ring-blue-300" required>
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">Apellido</label>
                <input type="text" name="last_name" class="w-full mt-1 p-2 border rounded-md focus:ring focus:ring-blue-300" required>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="w-full mt-1 p-2 border rounded-md focus:ring focus:ring-blue-300" required>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" name="password" class="w-full mt-1 p-2 border rounded-md focus:ring focus:ring-blue-300" required>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="w-full mt-1 p-2 border rounded-md focus:ring focus:ring-blue-300" required>
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                <select name="role" class="w-full mt-1 p-2 border rounded-md focus:ring focus:ring-blue-300" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
