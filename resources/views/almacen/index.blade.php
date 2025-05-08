<x-app-layout>
    <div class="container mx-auto p-6 space-y-6">
        <!-- Selector de almacén -->
        <livewire:components.karness-list />
        <!-- Barra de búsqueda -->
        <div class="bg-white shadow-md p-5 rounded-lg">
            <label class="block font-semibold text-lg text-gray-700">Buscar Insumo</label>
            <div class="relative mt-2">
                <input type="text" class="w-full p-3 pl-10 rounded-full border focus:ring focus:ring-blue-300 focus:outline-none" placeholder="Buscar insumo...">
                <span class="absolute left-4 top-3 text-gray-400"><i class="fas fa-search"></i></span>
            </div>
        </div>

        <!-- Resultados -->
        <div class="text-center bg-blue-900 text-white p-4 rounded-lg shadow-md">
            <p class="text-lg font-semibold">Sin resultados</p>
        </div>

        <!-- Botones de acción -->
        <div class="flex flex-col md:flex-row justify-center md:justify-around gap-4">
            <button class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-lg shadow-md transition">
                Agregar nuevo insumo
            </button>
            <button class="bg-red-700 hover:bg-red-800 text-white px-6 py-3 rounded-lg shadow-md transition">
                Eliminar insumo
            </button>
            <button class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-lg shadow-md transition">
                Actualizar insumo
            </button>
        </div>
    </div>
</x-app-layout>
