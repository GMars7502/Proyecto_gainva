<div class="container mx-auto p-6 space-y-6">


    
    
   
   
        <!-- Selector de almacén -->
    <div class="flex items-center justify-between bg-white shadow-md p-5 rounded-lg">
        
        <div>
            <label class="block font-semibold text-lg text-gray-700">Inventario :</label>
            <select  wire:change="loadKarness" wire:model.live='inventario' class="w-full p-3 border rounded-md focus:ring focus:ring-blue-300">
                <option value="Principal">Inventario Principal</option>
                <option value="Secundario">Inventario Secundario</option>
            </select>

            
        </div>

        <i wire:loading wire:target="inventario" class="fas fa-spinner fa-spin text-blue-600"></i>

        <div class="mt-4 flex justify-center">

        @can('almacen.create')
            <button @click="openCrearModal" title="Crear" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-lg shadow-md transition">
                Agregar nuevo insumo
            </button>
        </div>
        @endcan
    </div>


    <div class="relative">
    <!-- Overlay de carga -->
        <div wire:loading wire:target="inventario" >
            <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-50">
                <i class="fas fa-spinner fa-spin text-blue-700 text-4xl"></i>
            </div>
        </div>

    <!-- Tarjetas de Karness -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        


        @foreach ($karness as $kar)
            <div  wire:key="kar-{{ $kar->id }}" class="bg-blue-900 text-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold">Karness {{ $kar->nombre }}</h2>
                <ul class="mt-3 space-y-1">
                    @foreach ($kar->insumos as $insumo)
                        <li class="flex items-center justify-between text-sm opacity-80 hover:opacity-100 transition">
                            <a href="{{ route('almacen.karness', ['insumoId' => $insumo->idInsumo, 'almacen' => $inventario]) }}" class="block text-sm opacity-80 hover:opacity-100 hover:text-yellow-300 transition">
                                {{ $insumo->Nombre }}
                            </a>

                            <div class="flex space-x-2">
                                @can('almacen.edit')
                                <button @click="openEditModal({{ $insumo->idInsumo }})" title="Editar" class="p-1 sm:p-1.5 text-yellow-400 hover:text-yellow-300 transition duration-150">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828zM4 16a2 2 0 01-2-2v-2h1v2a1 1 0 001 1h12a1 1 0 001-1v-6h-2v6H4z"></path>
                                    </svg>
                                </button>
                                @endcan
                                
                                @can('almacen.delete')
                                <button @click="confirmDelete({{ $insumo->idInsumo }})" title="Eliminar" class="p-1 sm:p-1.5 text-red-500 hover:text-red-400 transition duration-150">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm2 4a1 1 0 100 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                @endcan
                            </div>

                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>


    </div>



    <!--Prueba de modal-->



    
    

    
</div>
