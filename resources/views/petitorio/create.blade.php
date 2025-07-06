<x-app-layout>

<div x-data="petitorioCrear(config)" x-init="init()">
    
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Gestión de Petitorio → Crear Petitorio</h1>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="petitorioForm()" x-init="init()">
            <!-- Pasar insumos a Alpine -->
            <script>
                window.petitorioInsumos = @json($listInsumos);
            </script>

            <!-- Campos principales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block font-semibold mb-1">Fecha Servicio</label>
                    <input type="date" class="w-full p-2 border rounded" x-model="fecha_servicio">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Status Proceso</label>
                    <input type="text" class="w-full p-2 border rounded bg-gray-100 cursor-not-allowed"
                        x-model="status_proceso" readonly>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Status Confirmación</label>
                    <input type="text" class="w-full p-2 border rounded bg-gray-100 cursor-not-allowed"
                        x-model="status_confirmacion" readonly>
                </div>
            </div>

            <!-- Insumos en 3 columnas -->
            <div class="overflow-auto mb-6">
                <table class="min-w-full text-sm bg-blue-900 text-white rounded shadow">
                    <thead class="text-left uppercase text-xs bg-blue-800">
                        <tr>
                            <th class="p-2">#</th>
                            <th class="p-2">Nombre Insumo</th>
                            <th class="p-2">Cantidad</th>
                            <th class="p-2">Stock disponible</th>
                            <th classs="p-2">Control_lote</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in insumos" :key="index">
                            <tr class="border-t border-blue-800">
                                <td class="p-2" x-text="index + 1"></td>
                                <td class="p-2 truncate" x-text="item.Nombre"></td>
                                <td class="p-2">
                                    <input 
                                        type="number" 
                                        class="w-20 text-black p-1 rounded" 
                                        x-model.number="item.cantidad"
                                        :max="item.stock"
                                        :min="0"
                                        :disabled="item.stock === 0"
                                        @input="if (Number(item.cantidad) > Number(item.stock)) { 
                                            
                                            alert('La cantidad no puede ser mayor al stock disponible.');
                                            item.cantidad = item.stock;  
                                        } else if (Number(item.cantidad) <= 0) {
                                            item.cantidad = 0;
                                        }"
                                    />
                                </td>
                                <td class="p-2 truncate" x-text="item.stock"></td>
                                <td class="p-2 truncate" x-text="item.control_cebado"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Observación -->
            <div class="mb-6">
                <label class="block font-semibold mb-1">Observación</label>
                <textarea class="w-full p-2 border rounded" rows="3" x-model="observacion"></textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4">
                <button type="button" @click="limpiar"
                        class="px-4 py-2 bg-cyan-300 hover:bg-cyan-400 text-black font-semibold rounded shadow">
                    Limpiar
                </button>
                <a href="{{ route('petitorio.index') }}"
                   class="px-4 py-2 bg-red-300 hover:bg-red-400 text-black font-semibold rounded shadow">
                    Cancelar
                </a>
                <button type="button" @click="guardar"
                        class="px-4 py-2 bg-green-300 hover:bg-green-400 text-black font-semibold rounded shadow">
                    Guardar
                </button>
            </div>
        </div>
    </div>


    
    <script>
    window.config = {
        csrfToken: '{{ csrf_token() }}',// Esto escapa automáticamente
        apiEndpoints: {
            createPetitorio: '{{ route('petitorio.store') }}',
            }
    };
    </script>

</div>
</x-app-layout>
