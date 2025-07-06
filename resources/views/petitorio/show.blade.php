<x-app-layout>
    <div x-data="petitorioEditar(config)" x-init="init()">

        <x-slot name="header">
            <h1 class="text-xl font-semibold text-gray-800">Gestión de Petitorio → Mostrar Petitorio</h1>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Feedback -->
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

                <!-- Formulario -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block font-semibold mb-1">Fecha Servicio</label>
                        <input type="date" class="w-full p-2 border rounded" x-model="form.fecha_servicio" readonly>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Status Proceso</label>
                        <input type="text" class="w-full p-2 border rounded bg-gray-100" x-model="form.status_proceso" readonly>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Status Confirmación</label>
                        <input type="text" class="w-full p-2 border rounded bg-gray-100" x-model="form.status_confirmacion" readonly>
                    </div>
                </div>

                <!-- Tabla de Insumos -->
                <div class="overflow-auto mb-6">
                    <table class="min-w-full text-sm bg-blue-900 text-white rounded shadow">
                        <thead class="text-left uppercase text-xs bg-blue-800">
                            <tr>
                                <th class="p-2">#</th>
                                <th class="p-2">Producto</th>
                                <th class="p-2">Cantidad</th>
                                <th class="p-2">Stock disponible</th>
                                <th class="p-2">Contro Lote</th>
                                <th class= "p-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in form.insumos" :key="index">
                                <tr class="border-t border-blue-800">
                                    <td class="p-2" x-text="index + 1"></td>
                                    <td class="p-2" x-text="item.nombre || item.Nombre || 'Producto ' + item.idProducto"></td>
                                    <td class="p-2">
                                        <input type="number" class="w-20 text-black p-1 rounded" x-model="item.cantidad_salida"
                                        :max="item.stock"
                                        :min="0"
                                        :disabled
                                        @input="if (Number(item.cantidad_salida) > Number(item.stock)) { 
                                            
                                            alert('La cantidad no puede ser mayor al stock disponible.');
                                            item.cantidad = item.stock; 
                                        } else if (Number(item.cantidad_salida) <= 0) {
                                            item.cantidad_salida = 0;
                                        }" disabled>
                                    </td>
                                    <td class="p-2" x-text="item.stock || '0'"></td>
                                    <td class="p-2" x-text="item.control_lote"></td>
                                    <td class="p-2">
                                        <div class="flex gap-2">
                                           
                                            <div class="flex gap-2" x-show="['borrador','rectificado', 'confirmado', 'cancelado'].includes(form.status_proceso) && item.control_lote === 'Y' && Number(item.cantidad_salida) > 0">
                                                <button type="button"
                                                        class="px-2 py-1 bg-yellow-400 hover:bg-yellow-500 text-black text-xs rounded shadow"
                                                        @click="abrirModalLote(item)">
                                                    Get. Lotes
                                                </button>
                                            </div>


                                            

                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Observación general -->
                <div class="mb-6">
                    <label class="block font-semibold mb-1">Observación general</label>
                    <textarea class="w-full p-2 border rounded" rows="3" x-model="form.observacion" disabled></textarea>
                </div>

                <a href="{{ route('petitorio.index') }}"
                    class="px-4 py-2 bg-red-300 hover:bg-red-400 text-black font-semibold rounded shadow">
                        Salir
                </a>


            </div>
        </div>

        <!-- Config Alpine -->
        <script>

            console.log(@json($lotesConCantidadesPorInsumo));

            window.config = {
                csrfToken: '{{ csrf_token() }}',
                apiEndpoints: {
                    updatePetitorio: '{{ route('petitorio.update', $petitorio->idpetitorio) }}',
                },
                petitorio: @json($petitorio),
                loteConCantidades: @json($lotesConCantidadesPorInsumo)
            };
        </script>
   


                    <!-- Modal Lotes -->
                <div x-show="modalAbierto"
                    style="background-color: rgba(0, 0, 0, 0.6)"
                    class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded shadow-xl w-full max-w-lg">
                        <h2 class="text-lg font-bold mb-4">Editar Lotes - <span x-text="loteActual.lote || loteActual.Nombre"></span></h2>

                        <template x-if="form.status_proceso === 'nunca'">
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                <template x-for="(lote, index) in lotesSeleccionados" :key="index">
                                    <div class="grid grid-cols-3 gap-2 items-center">
                                        <div>
                                            <span class="font-semibold">Lote:</span>
                                            <span x-text="lote.lote"></span>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500">Disponible: <span x-text="lote.cantidad_disponible"></span></span>
                                        </div>
                                        <div>
                                            <input type="number" class="w-full border p-1 rounded text-black"
                                                min="0"
                                                :max="Number(lote.cantidad_disponible)"
                                                x-model.number="lote.cantidad">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <template x-if="form.status_proceso !== 'nunca'">
                            <div class="text-gray-700 text-sm">
                                <p>No tienes los permisos para editar o eliminar lotes.</p>
                                <template x-if="loteActual.lotes_asignados">
                                    <ul class="mt-2 space-y-1">
                                        <template x-for="(lote, index) in loteActual.lotes_asignados" :key="index">
                                            <li>
                                                <strong>Lote:</strong> <span x-text="lote.lote"></span>,
                                                <strong>Cant:</strong> <span x-text="lote.cantidad"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </template>
                            </div>
                        </template>
                        
                        <div class="mt-4 text-right">
                            <button class="px-4 py-2 bg-red-300 rounded hover:bg-red-400 text-sm" @click="cerrarModalCalcelar">Cancelar</button>
                        </div>


                    </div>
                </div>


     </div>



</x-app-layout>
