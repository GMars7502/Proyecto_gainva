{{-- resources/views/livewire/components/karness-registro.blade.php --}}
{{-- 



    
    Se dejo de utilizar esta componente:
    Este componente se utilizaba para mostrar los registros de cada Insumo 
    pero se dejo de utilizar por lentitud en la carga de datos.





    --}}

<div class="container mx-auto px-6 py-10 space-y-10 text-gray-800">
    
    <div class="flex flex-wrap justify-center gap-10 items-end">
        <div>
            <label class="block text-base font-medium text-blue-900 mb-2">Año</label>
            <select wire:model="anio" class="bg-white border border-blue-300 text-blue-900 font-semibold px-6 py-2 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500">
                @for ($year = 2020; $year <= now()->year; $year++)
                    <option value="{{ $year }}">{{ $year }}</option> {{-- Quitamos el selected, wire:model lo maneja --}}
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-base font-medium text-blue-900 mb-2">Mes</label>
            <select wire:model="mes" class="bg-white border border-blue-300 text-blue-900 font-semibold px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500">
                @php
                    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                @endphp
                @foreach ($meses as $index => $nombreMes)
                    <option value="{{ $index + 1 }}">{{ $nombreMes }}</option> {{-- Quitamos el selected --}}
                @endforeach
            </select>
        </div>
        {{-- Aquí irán los iconos de PDF más tarde --}}
    </div>

    <div class="transition-all duration-300 overflow-hidden">
        <div class="flex justify-center items-center gap-4 sm:gap-6 text-white">
            {{-- Botón Anterior --}}
            @if($this->insumoAnterior)
                <button wire:click="anterior"
                    class="min-w-[12rem] flex items-center justify-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 transition px-4 py-2 rounded-lg shadow-md text-sm font-semibold truncate">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"> <path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L7 10.414a1 1 0 010-1.414l4.293-4.293a1 1 0 111.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd" /> </svg>
                    <span class="underline truncate">{{ $this->insumoAnterior->Nombre }}</span>
                </button>
            @endif

            {{-- Nombre actual (Añadiremos desplegable aquí luego) --}}
            <div class="min-w-[16rem] text-center bg-blue-800 px-6 py-3 rounded-lg shadow-md font-bold text-lg truncate">
                {{ $this->insumo?->Nombre }} {{-- Usamos optional() o ?-> por si acaso --}}
            </div>

            {{-- Botón Siguiente --}}
            @if($this->insumoSiguiente)
                <button wire:click="siguiente"
                    class="min-w-[12rem] flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 transition px-4 py-2 rounded-lg shadow-md text-sm font-semibold truncate">
                    <span class="underline truncate">{{ $this->insumoSiguiente->Nombre }}</span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"> <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414L13 10.414a1 1 0 010 1.414l-4.293 4.293a1 1 0 01-1.414 0z" clip-rule="evenodd" /> </svg>
                </button>
            @endif
        </div>
    </div>

    <div class="text-right">
         <button wire:click="openCreateModal" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow text-sm font-semibold">
             ➕ Crear Movimiento
         </button>
    </div>

    <div x-data="karnessModals">


            <div class="bg-blue-900 text-white p-6 rounded-lg shadow-md relative">


                {{-- Cargando --}}
                <div wire:loading wire:target="anterior, siguiente">
                    {{-- El icono spinner --}}
                    <div class="absolute inset-0 bg-blue-900 bg-opacity-75 flex items-center justify-center z-10">
                        <i class="fas fa-spinner fa-spin text-3xl text-white"></i>
                    </div>
                </div>
                
                <h2 class="text-2xl font-semibold text-center mb-4">{{ $almacen }} - {{ $this->insumo?->Nombre }}</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white">
                                <th class="py-2 px-4">Fecha</th>
                                <th class="py-2 px-4">Tipo Movimiento</th>
                                <th class="py-2 px-4">Cant. Movida</th>
                                <th class="py-2 px-4">Stock</th> {{-- Este será calculado --}}
                                {{-- <th class="py-2 px-4">Facturación</th>  Renombrado desde 'descripcion' en imagen? O falta 'descripcion'? Usaré 'facturacion' como en tu código original --}}
                                <th class="py-2 px-4">Observación</th> {{-- Asumo que este es 'descripcion' de la imagen --}}
                                <th class="py-2 px-4">Lote</th>
                                {{-- <th class="py-2 px-4">Proveedor</th> --}}
                                <th class="py-2 px-4 text-center">Acciones</th> {{-- Nueva Columna --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Cambiamos $movimientos->keyBy('id') a colección de objetos --}}
                            @forelse($movimientos as $mov)
                                <tr class="border-t border-gray-400 hover:bg-blue-800 text-sm">
                                    {{-- Mostramos datos directamente, sin inputs --}}
                                    <td class="py-2 px-4">{{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}</td>
                                    <td class="py-2 px-4">{{ $mov->tipo_movimiento ?: '-' }}</td>
                                    <td class="py-2 px-4 text-center {{ $mov->tipoMovimiento == 'entrada' ? 'text-green-400' : ($mov->tipoMovimiento == 'salida' ? 'text-red-400' : '') }}">
                                        {{ $mov->cant_movida ?? '-' }}
                                    </td>
                                    <td class="py-2 px-4 text-center">{{ $mov->stock ?? '-' }}</td> {{-- Mostraremos el stock calculado aquí eventualmente --}}
                                    {{-- <td class="py-2 px-4">{{ $mov->facturacion ?: '-' }}</td> --}}
                                    <td class="py-2 px-4">{{ $mov->observacion ?: '-' }}</td>
                                    <td class="py-2 px-4">{{ $mov->lote ?: '-' }}</td>
                                    {{-- <td class="py-2 px-4">{{ $mov->proveedor ?: '-' }}</td> --}}
                                    {{-- Columna de Acciones --}}
                                    <td class="py-2 px-4 text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            {{-- Botón Editar --}}
                                            <button wire:click="openEditModal({{ $mov->idMovimiento }})" title="Editar"
                                                    class="text-yellow-400 hover:text-yellow-300 transition duration-150">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828zM4 16a2 2 0 01-2-2v-2h1v2a1 1 0 001 1h12a1 1 0 001-1v-6h-2v6H4z"></path></svg>
                                            </button>
                                            {{-- Botón Eliminar --}}
                                            
                                                <button @click="openDeleteModal({{ $mov->idMovimiento }})" title="Eliminar"
                                                        class="text-red-500 hover:text-red-400 transition duration-150">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm2 4a1 1 0 100 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            
                                            {{-- Botón Ver (opcional, si lo necesitas) --}}
                                            <button wire:click="openViewModal({{ $mov->idMovimiento }})" title="Ver Detalles"
                                                    class="text-blue-400 hover:text-blue-300 transition duration-150">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zm15.083-1a14.914 14.914 0 00-2.531-3.145A15.008 15.008 0 0010 5c-1.84 0-3.58.46-5.052 1.287A14.913 14.913 0 002.469 9a14.914 14.914 0 002.531 3.145A15.008 15.008 0 0010 13c1.84 0 3.58-.46 5.052-1.287A14.913 14.913 0 0017.531 9a14.914 14.914 0 00-.99-1z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="10" class="py-4 text-gray-400 italic">No hay movimientos registrados para este mes/año.</td> {{-- Ajustado colspan --}}
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                

                <div class="mt-6 text-center">
                    <button wire:click="openCreateModal" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                        ➕ Agregar Movimiento
                    </button>
                </div>
            
            </div>











            {-- ****** INICIO: Modal Confirmación de Borrado (CON ALPINE) ****** --}}
            <div x-show="showConfirmDeleteModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @keydown.escape.window="closeDeleteModal()"
                class="fixed inset-0 z-50 overflow-auto bg-gray-800 bg-opacity-50 flex"
                style="display: none;" {{-- Evitar flash inicial --}}
                >
                <div class="relative p-8 bg-white w-full max-w-md m-auto flex-col flex rounded-lg shadow-lg">
                    {{-- Título y botón cerrar --}}
                    <div class="flex justify-between items-center pb-3">
                        <p class="text-2xl font-bold text-gray-700">Confirmar Eliminación</p>
                        <button @click="closeDeleteModal()" class="text-gray-500 hover:text-gray-700">X</button>
                    </div>
                    {{-- Contenido --}}
                    <div class="py-4 text-gray-700">
                        ¿Estás seguro de que deseas eliminar este movimiento? (ID: <span x-text="movementIdToDelete" class="font-semibold"></span>) Esta acción no se puede deshacer.
                    </div>
                    {{-- Botones --}}
                    <div class="flex justify-end pt-4 space-x-4">
                        <button @click="closeDeleteModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition duration-150">
                            Cancelar
                        </button>
                        <button @click="deleteMovement()"
                                :disabled="isLoadingDelete"
                                class="inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition duration-150 disabled:opacity-75">
                            <i x-show="isLoadingDelete" class="fas fa-spinner fa-spin mr-2"></i>
                            <span x-text="isLoadingDelete ? 'Eliminando...' : 'Sí, Eliminar'"></span>
                        </button>
                    </div>
                </div>
                </div>

    <div>

        



</div>