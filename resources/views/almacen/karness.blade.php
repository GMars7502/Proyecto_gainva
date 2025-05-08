{{-- resources/views/almacen/karness.blade.php --}}
<x-app-layout>
<div x-data="karnessRegistro(window.karnessConfig)"
         x-init="init()"
         class="container mx-auto px-6 py-10 space-y-10 text-gray-800" {{-- Contenedor principal y espaciado --}}
    >
        {{-- Título (opcional, puedes quitarlo o estilizarlo mejor) --}}
        <h1 class="text-2xl font-semibold text-center text-blue-900">
            Karness para Insumo: <span x-text="insumoActual ? insumoActual.Nombre : (insumoId ? 'ID ' + insumoId : 'Cargando...')" class="text-blue-700"></span>
            en Almacén: <span x-text="almacen" class="text-blue-700"></span>
        </h1>

        <?php   
        #region AñoyMes 
        ?>

        {{-- 1. Selectores de Año y Mes --}}
        <div class="flex flex-wrap justify-center gap-6 sm:gap-10 items-end bg-white p-5 rounded-lg shadow">
            <div>
                <label for="karness-year" class="block text-sm sm:text-base font-medium text-blue-900 mb-1 sm:mb-2">Año</label>
                <select id="karness-year"
                        x-model="selectedYear"
                        @change="fetchMovimientos()"
                        class="bg-white border border-blue-300 text-blue-900 font-semibold px-4 sm:px-6 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        :disabled="isLoadingTable"
                >
                    @for ($year = 2020; $year <= now()->year; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="karness-month" class="block text-sm sm:text-base font-medium text-blue-900 mb-1 sm:mb-2">Mes</label>
                <select id="karness-month"
                        x-model="selectedMonth"
                        @change="fetchMovimientos()"
                        class="bg-white border border-blue-300 text-blue-900 font-semibold px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        :disabled="isLoadingTable"
                >
                    @php $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']; @endphp
                    @foreach ($meses as $index => $nombreMes)
                        <option value="{{ $index + 1 }}">{{ $nombreMes }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Espacio para futuros iconos/botones PDF --}}
        </div>

        <?php   
        #region BarraNavega 
        ?>
        {{-- 2. Barra de Navegación de Insumos --}}
        <div class="overflow-hidden"> {{-- Contenedor para evitar que el gradiente se corte bruscamente --}}
            <div class="flex flex-col sm:flex-row justify-center items-center gap-2 sm:gap-4 md:gap-6 text-white">
                {{-- Botón Anterior --}}
                <div class="min-w-full sm:min-w-[10rem] md:min-w-[12rem] h-[calc(2.25rem+2px)] flex items-center justify-center">
                    <template x-if="insumoAnterior">
                        <button @click="navigateToInsumo(insumoAnterior.idInsumo)"
                                class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-cyan-600 to-blue-700 hover:from-cyan-500 hover:to-blue-600 transition-all duration-300 ease-in-out px-4 py-2 rounded-lg shadow-md text-xs sm:text-sm font-semibold truncate">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"> <path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L7 10.414a1 1 0 010-1.414l4.293-4.293a1 1 0 111.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd" /> </svg>
                            <span class="underline truncate" x-text="insumoAnterior.Nombre"></span>
                        </button>
                    </template>
                    <div x-show="!insumoAnterior" class="w-full h-full"></div> {{-- Placeholder para mantener espacio --}}
                </div>

                {{-- Nombre del Insumo Actual --}}
                <div class="min-w-full sm:min-w-[14rem] md:min-w-[16rem] text-center bg-blue-800 px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md font-bold text-sm sm:text-base md:text-lg truncate h-[calc(2.75rem+2px)] sm:h-[calc(3rem+2px)] flex items-center justify-center">
                     <span x-text="insumoActual ? insumoActual.Nombre : (insumoId ? 'Cargando...' : 'Seleccione Insumo')"></span>
                </div>

                {{-- Botón Siguiente --}}
                <div class="min-w-full sm:min-w-[10rem] md:min-w-[12rem] h-[calc(2.25rem+2px)] flex items-center justify-center">
                    <template x-if="insumoSiguiente">
                        <button @click="navigateToInsumo(insumoSiguiente.idInsumo)"
                                class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-blue-700 to-cyan-600 hover:from-blue-600 hover:to-cyan-500 transition-all duration-300 ease-in-out px-4 py-2 rounded-lg shadow-md text-xs sm:text-sm font-semibold truncate">
                            <span class="underline truncate" x-text="insumoSiguiente.Nombre"></span>
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"> <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414L13 10.414a1 1 0 010 1.414l-4.293 4.293a1 1 0 01-1.414 0z" clip-rule="evenodd" /> </svg>
                        </button>
                    </template>
                    <div x-show="!insumoSiguiente" class="w-full h-full"></div> {{-- Placeholder --}}
                </div>
            </div>
        </div>

        <?php   
        #region CrearMovi 
        ?>

        {{-- Botón "Crear Movimiento" (lo usaremos después) --}}
        <div class="text-right mt-6 mb-2">
            <button @click="openCreateModal()" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow hover:shadow-md transition text-sm font-semibold">
                <i class="fas fa-plus mr-2"></i> Crear Movimiento
            </button>
        </div>


        <?php   
        #region TablaMovi 
        ?>
        {{-- 3. Tabla de Movimientos --}}
        <div class="bg-blue-900 text-white p-4 sm:p-6 rounded-lg shadow-xl relative">
            {{-- Indicador de Carga Tabla --}}
            <div x-show="isLoadingTable" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200"
                 class="absolute inset-0 bg-blue-900 bg-opacity-80 flex items-center justify-center z-20 rounded-lg">
                <i class="fas fa-spinner fa-spin text-3xl sm:text-4xl text-white"></i>
            </div>

            {{-- Título de la Tabla --}}
            <h2 class="text-xl sm:text-2xl font-semibold text-center mb-4">
                 Movimientos: <span x-text="almacen"></span> - <span x-text="insumoActual ? insumoActual.Nombre : 'Insumo'"></span>
            </h2>
            <p class="text-center text-sm text-blue-300 mb-4">Año: <span x-text="selectedYear"></span>, Mes: <span x-text="selectedMonth"></span></p>


            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-blue-800">
                        <tr class="border-b border-blue-700">
                            <th class="py-2.5 sm:py-3 px-3 sm:px-4 text-xs sm:text-sm uppercase font-semibold">Fecha</th>
                            <th class="py-2.5 sm:py-3 px-3 sm:px-4 text-xs sm:text-sm uppercase font-semibold">Tipo</th>
                            <th class="py-2.5 sm:py-3 px-3 sm:px-4 text-xs sm:text-sm uppercase font-semibold text-center">Cantidad</th>
                            <th class="py-2.5 sm:py-3 px-3 sm:px-4 text-xs sm:text-sm uppercase font-semibold text-center">Stock</th>
                            <th class="py-2.5 sm:py-3 px-3 sm:px-4 text-xs sm:text-sm uppercase font-semibold">Observación</th>
                            <th class="py-2.5 sm:py-3 px-3 sm:px-4 text-xs sm:text-sm uppercase font-semibold">Lote</th>
                            <th class="py-2.5 sm:py-3 px-3 sm:px-4 text-xs sm:text-sm uppercase font-semibold text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-700">
                        <template x-if="!isLoadingTable && movimientos.length === 0">
                           <tr class="bg-blue-800 hover:bg-blue-700 transition-colors">
                               <td colspan="7" class="py-4 px-3 sm:px-4 text-center text-sm text-blue-300 italic">
                                   No hay movimientos registrados para este insumo en el período seleccionado.
                               </td>
                           </tr>
                        </template>
                         <template x-for="movimiento in movimientos" :key="movimiento.idMovimiento"> {{-- Usa tu PK aquí --}}
                            <tr class="bg-blue-800 hover:bg-blue-700 transition-colors text-xs sm:text-sm">
                                <td class="py-2 px-3 sm:px-4" x-text="formatDate(movimiento.fecha)"></td>
                                <td class="py-2 px-3 sm:px-4" x-text="movimiento.tipo_movimiento"></td>
                                <td class="py-2 px-3 sm:px-4 text-center"
                                    :class="{
                                        'text-green-400 font-bold': movimiento.tipo_movimiento === 'entrada',
                                        'text-red-400 font-bold': movimiento.tipo_movimiento === 'salida'
                                    }"
                                    x-text="movimiento.cant_movida">
                                </td>
                                <td class="py-2 px-3 sm:px-4 text-center font-medium" x-text="movimiento.stock"></td>
                                <td class="py-2 px-3 sm:px-4 truncate max-w-xs" :title="movimiento.observacion" x-text="movimiento.observacion || '-'"></td>
                                <td class="py-2 px-3 sm:px-4" x-text="movimiento.lote || '-'"></td>
                                <td class="py-2 px-3 sm:px-4 text-center">
                                    <div class="flex justify-center items-center space-x-1 sm:space-x-2">
                                        <button @click="openEditModal(movimiento)" title="Editar" class="p-1 sm:p-1.5 text-yellow-400 hover:text-yellow-300 transition duration-150">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828zM4 16a2 2 0 01-2-2v-2h1v2a1 1 0 001 1h12a1 1 0 001-1v-6h-2v6H4z"></path></svg>
                                        </button>
                                        <button @click="confirmDelete(movimiento.idMovimiento)" title="Eliminar" class="p-1 sm:p-1.5 text-red-500 hover:text-red-400 transition duration-150">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm2 4a1 1 0 100 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
                                        </button>
                                        <button @click="openViewModal(movimiento)" title="Ver Detalles" class="p-1 sm:p-1.5 text-blue-400 hover:text-blue-300 transition duration-150">
                                             <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zm15.083-1a14.914 14.914 0 00-2.531-3.145A15.008 15.008 0 0010 5c-1.84 0-3.58.46-5.052 1.287A14.913 14.913 0 002.469 9a14.914 14.914 0 002.531 3.145A15.008 15.008 0 0010 13c1.84 0 3.58-.46 5.052-1.287A14.913 14.913 0 0017.531 9a14.914 14.914 0 00-.99-1z" clip-rule="evenodd"></path></svg>
                                         </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
        <?php   
        #region Modales 
        ?>









        <?php   
        #region 🧩Eliminar 
        ?>
        {{-- Modal para Confirmar Borrado (usará karnessModals.js o lógica integrada) --}}
        <div x-show="showConfirmDeleteModal"  
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @keydown.escape.window="closeConfirmDeleteModal()" {{-- Cerrar con tecla Escape --}}
             class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-60 flex items-center justify-center p-4"
             style="display: none;" {{-- Oculto por defecto, Alpine lo muestra --}}
        >
        {{-- Contenedor del Modal --}}
            <div @click.outside="closeConfirmDeleteModal()" {{-- Cerrar si se hace clic fuera (opcional) --}}
                 class="relative p-6 sm:p-8 bg-white w-full max-w-md m-auto flex-col flex rounded-lg shadow-xl"
            >
                {{-- Encabezado del Modal --}}
                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                    <p class="text-xl sm:text-2xl font-bold text-gray-700">Confirmar Eliminación</p>
                    <button @click="closeConfirmDeleteModal()" title="Cerrar modal"
                            class="text-gray-400 hover:text-gray-600 transition text-2xl sm:text-3xl leading-none">
                        &times; {{-- Caracter de 'X' para cerrar --}}
                    </button>
                </div>

                {{-- Cuerpo del Modal --}}
                <div class="py-4 sm:py-5 text-gray-700 text-sm sm:text-base">
                    <p>¿Estás seguro de que deseas eliminar este movimiento?</p>
                    <p class="mt-1">ID del Movimiento: <strong x-text="movementIdToDelete" class="text-blue-700"></strong></p>
                    <p class="mt-2 text-red-600 font-semibold">Esta acción no se puede deshacer.</p>
                </div>

                {{-- Pie del Modal (Botones) --}}
                <div class="flex justify-end pt-4 space-x-3 border-t border-gray-200">
                    <button @click="closeConfirmDeleteModal()"
                            :disabled="isDeletingMovement" {{-- Deshabilitar si está borrando --}}
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition text-sm font-medium disabled:opacity-70">
                        Cancelar
                    </button>
                    <button @click="deleteMovement()" {{-- Llama a la función de borrado --}}
                            :disabled="isDeletingMovement"
                            class="inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition text-sm font-medium disabled:opacity-70 disabled:bg-red-400">
                        {{-- Icono de carga y texto dinámico --}}
                        <i x-show="isDeletingMovement" class="fas fa-spinner fa-spin -ml-1 mr-2 h-4 w-4 text-white"></i>
                        <span x-text="isDeletingMovement ? 'Eliminando...' : 'Sí, Eliminar'"></span>
                    </button>
                </div>
            </div>
        </div>




        <?php   
        #region 🧩Crear
        ?>
        {{-- Modal para Crear Movimiento --}}
        {{-- <div x-show="showCreateModal">...</div> --}}
        {{-- Modal para Editar Movimiento --}}
        {{-- <div x-show="showEditModal">...</div> --}}
        {{-- Modal para Ver Movimiento --}}
        {{-- <div x-show="showViewModal">...</div> --}}


    </div>

    <script>
    window.karnessConfig = {
        initialInsumoId: {{ $insumoId ?? 'null' }},
        initialAlmacen: '{{ $almacen ?? '' }}',
        initialYear: {{now()->year}},
        initialMonth: {{now()->month}},
        csrfToken: '{{ csrf_token() }}',
        initialInsumoList: @json($listaInsumos?? []), // Esto escapa automáticamente
        apiEndpoints: {
            getmovimientos: '/movimiento_almacen/get-movimientos/{$insumoId}',
            deletemovimiento: '/movimiento_almacen/{movimientoid}',
        }
    };
    </script>
</x-app-layout>
