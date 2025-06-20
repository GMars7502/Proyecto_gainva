<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Usuario</h1>

            <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-gray-700 font-semibold">Nombre</label>
                    <input type="text" name="name" value="{{ $user->name }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label for="last_name" class="block text-gray-700 font-semibold">Apellido</label>
                    <input type="text" name="last_name" value="{{ $user->last_name }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                </div>

                <div>
                <label for="role" class="block text-gray-700 font-semibold">Contraeña nueva (No ingresar nada si no quiere actualizar)</label>
                            
                    <input type="password" name="password" value="{{ old('password') }}"
                        placeholder="Ingresar contraseña"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 form-control @error('password') is-invalid @enderror">

                                   
                </div>

                <div>
                    <label for="role" class="block text-gray-700 font-semibold">Confirma contraseña</label>
                    <input type="password" name="password_confirmation"
                                            value="{{ old('password_confirmation') }}"
                                            placeholder="Ingresar confirmacion de contraseña" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">

                </div>

                

                <div>
                    <label for="role" class="block text-gray-700 font-semibold">Rol</label>
                    <select name="role" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('users.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
