{{-- resources/views/almacen/karness.blade.php --}}
<x-app-layout>


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
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Gestión Almacen / Karness</h1>
    </x-slot>












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
        #endregion
        ?>

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

                {{-- Insumo Actual - AHORA COMO SELECT DESPLEGABLE --}}
                <div class="min-w-full sm:min-w-[14rem] md:min-w-[16rem] relative h-[calc(2.75rem+2px)] sm:h-[calc(3rem+2px)] flex items-center justify-center">
                    <select
                        @change="navigateToInsumo($event.target.value)"
                        :disabled="isLoadingTable"
                        class="w-full appearance-none text-center bg-blue-800 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md font-bold text-sm sm:text-base md:text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 cursor-pointer"
                        aria-label="Seleccionar Insumo"
                    >
                        <template x-for="insumo in insumoList" :key="insumo.idInsumo">
                            <option
                                :value="insumo.idInsumo"
                                x-text="insumo.Nombre"
                                :selected="insumo.idInsumo === insumoId"
                            ></option>
                        </template>
                    </select>
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
        #endregion
        ?>

        <?php   
        #region CrearMovi 
        ?>

        {{-- Botón "Crear Movimiento" (lo usaremos después) --}}
        <div class="text-right mt-6 mb-2">
            @can('movimiento.create')
            <button @click="openCreateModal()" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow hover:shadow-md transition text-sm font-semibold">
                <i class="fas fa-plus mr-2"></i> Crear Movimiento
            </button>
            @endcan
        </div>

        <?php   
        #endregion
        ?>


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
            <p class="text-center text-sm text-blue-300 mb-4">Año: <span x-text="selectedYear"></span>, Mes: <span x-text="selectedMonth"></span>,  Total en Stock: <span x-text="totalStock"></span></p>


            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-blue-800">
                        <tr class="border-b border-blue-700">
                            <th class="py-2.5 sm:py-3 px-3 sm:px-4 text-xs sm:text-sm uppercase font-semibold">Fecha</th>
                            <th class="py-2.5 sm:py-3 px-3 sm:px-4 text-xs sm:text-sm uppercase font-semibold">Tipo</th>
                            <th class="py-2.5 sm:py-3 px-3 sm:px-4 text-xs sm:text-sm uppercase font-semibold text-center">Cantidad</th>
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
                                <td class="py-2 px-3 sm:px-4" x-text="movimiento.fecha"></td>
                                <td class="py-2 px-3 sm:px-4" x-text="movimiento.tipo_movimiento"></td>
                                <td class="py-2 px-3 sm:px-4 text-center"
                                    :class="{
                                        'text-green-400 font-bold': movimiento.tipo_movimiento === 'entrada',
                                        'text-red-400 font-bold': movimiento.tipo_movimiento === 'salida'
                                    }"
                                    x-text="movimiento.cant_movida">
                                </td>
                                <td class="py-2 px-3 sm:px-4 truncate max-w-xs" :title="movimiento.observacion" x-text="movimiento.observacion || '-'"></td>
                                <td class="py-2 px-3 sm:px-4" x-text="movimiento.lote || '-'"></td>
                                <td class="py-2 px-3 sm:px-4 text-center">
                                    <div class="flex justify-center items-center space-x-1 sm:space-x-2">
                                        @can('movimiento.edit')
                                        <button @click="openEditModal(movimiento)" title="Editar" class="p-1 sm:p-1.5 text-yellow-400 hover:text-yellow-300 transition duration-150">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828zM4 16a2 2 0 01-2-2v-2h1v2a1 1 0 001 1h12a1 1 0 001-1v-6h-2v6H4z"></path></svg>
                                        </button>
                                        @endcan
                                        @can('movimiento.delete')
                                        <button @click="confirmDelete(movimiento.idMovimiento)" title="Eliminar" class="p-1 sm:p-1.5 text-red-500 hover:text-red-400 transition duration-150">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm2 4a1 1 0 100 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-6 mb-2">
                @can('movimiento.create')
                <button @click="openCreateModal()" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow hover:shadow-md transition text-sm font-semibold">
                    <i class="fas fa-plus mr-2"></i> Crear Movimiento
                </button>
                @endcan
            </div>

        </div>
        <?php   
        #endregion
        ?>


        <?php   
        #region Modales 
        ?>

        <?php   
        #endregion
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
        #endregion
        ?>


        <?php   
        #region 🧩Crear
        ?>

            <div x-show="showCreateModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                @keydown.escape.window="closeCreateModal()"
                class="fixed inset-0 z-40 overflow-y-auto p-4 bg-gray-900 bg-opacity-60 flex items-center justify-center"
                style="display: none;">

            <div @click.outside="closeCreateModal()" class="bg-blue-900 text-white rounded-lg shadow-xl w-full max-w-xl sm:max-w-2xl md:max-w-3xl max-h-[90vh] flex flex-col">

                {{-- Encabezado del Modal --}}
                <div class="flex justify-between items-center p-4 sm:p-5 border-b border-blue-700">
                    <h3 class="text-lg sm:text-xl font-semibold">Creación de Movimiento</h3>
                    <button @click="closeCreateModal()" class="text-blue-300 hover:text-white transition text-2xl">&times;</button>
                </div>

                {{-- Pestañas de Navegación --}}
                <div class="flex border-b border-blue-700">
                    <button @click="switchCreateTab('salidas')"
                            :class="{ 'bg-green-500 text-white font-bold': createModalTab === 'salidas', 'bg-blue-800 hover:bg-blue-700 text-blue-300': createModalTab !== 'salidas' }"
                            class="flex-1 py-2.5 sm:py-3 px-4 text-sm sm:text-base focus:outline-none transition">
                        Salidas
                    </button>
                    <button @click="switchCreateTab('entradas')"
                            :class="{ 'bg-green-500 text-white font-bold': createModalTab === 'entradas', 'bg-blue-800 hover:bg-blue-700 text-blue-300': createModalTab !== 'entradas' }"
                            class="flex-1 py-2.5 sm:py-3 px-4 text-sm sm:text-base focus:outline-none transition">
                        Entradas
                    </button>
                </div>

                {{-- Contenido de las Pestañas (overflow para el contenido interno) --}}
                <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-grow">

                    {{-- ***** Pestaña de SALIDAS ***** --}}
                    <div x-show="createModalTab === 'salidas'" class="space-y-3">
                        <template x-for="(salida, index) in newSalidas" :key="salida.id">
                            <div class="p-3 bg-blue-800 rounded-md shadow grid grid-cols-1 sm:grid-cols-10 gap-2 items-end">
                                {{-- Fecha --}}
                                <div class="sm:col-span-2">
                                    <label :for="'salida_fecha_'+index" class="block text-xs text-blue-300 mb-1">Fecha</label>
                                    <input type="date" :id="'salida_fecha_'+index" x-model="salida.fecha" 
                                    :min="minDateForCurrentMonth" :max="maxDateForCurrentMonth"
                                    class="w-full bg-blue-700 border-blue-600 rounded-md p-1.5 text-xs focus:ring-cyan-500 focus:border-cyan-500">
                                </div>
                                {{-- Cantidad Saca --}}
                                <div class="sm:col-span-2">
                                    <label :for="'salida_cant_'+index" class="block text-xs text-blue-300 mb-1">Cant. Saca</label>
                                    <input type="number" :id="'salida_cant_'+index" x-model.number="salida.cantSaca" placeholder="0" class="w-full bg-blue-700 border-blue-600 rounded-md p-1.5 text-xs focus:ring-cyan-500 focus:border-cyan-500">
                                </div>
                                {{-- Lote --}}
                                <div class="sm:col-span-2">
                                    <label :for="'salida_lote_'+index" class="block text-xs text-blue-300 mb-1">
                                        Lote <span x-show="isLoteRequiredForEntrada()" class="text-red-400">*</span>
                                    </label>

                                    {{-- Mostrar SELECT si el lote es mandatorio y hay lotes disponibles --}}
                                    <template x-if="isLoteRequiredForEntrada() && lotesDisponiblesParaSalida().length > 0">
                                        <select :id="'salida_lote_select_'+index"
                                                x-model="salida.lote"
                                                class="w-full bg-blue-700 border-blue-600 rounded-md p-1.5 text-xs focus:ring-cyan-500 focus:border-cyan-500 appearance-none">
                                            <option value="">Seleccione un lote...</option>
                                            <template x-for="item in lotesDisponiblesParaSalida()" :key="item.lote">
                                                <option :value="item.lote" x-text="`${item.lote} (Disp: ${item.stock})`"></option>
                                            </template>
                                        </select>
                                    </template>

                                    {{-- Mostrar INPUT TEXT si el lote es mandatorio PERO NO hay lotes cargados/disponibles (caso fallback o error) --}}
                                    <template x-if="isLoteRequiredForEntrada() && lotesDisponiblesParaSalida().length === 0">
                                        <input type="text" :id="'salida_lote_input_'+index"
                                            x-model="salida.lote"
                                            placeholder="Lote requerido"
                                            class="w-full bg-blue-700 border-blue-600 rounded-md p-1.5 text-xs focus:ring-cyan-500 focus:border-cyan-500 placeholder-blue-400">
                                        {{-- También podrías mostrar un mensaje como "No hay lotes con stock" --}}
                                        <p class="text-xxs text-yellow-400 mt-0.5" x-show="stockPorLoteData && stockPorLoteData.length > 0 && lotesDisponiblesParaSalida().length === 0">No hay lotes con stock positivo.</p>
                                        <p class="text-xxs text-yellow-400 mt-0.5" x-show="!stockPorLoteData || stockPorLoteData.length === 0">Info de lotes no disponible.</p>

                                    </template>

                                    {{-- Mostrar INPUT TEXT si el lote NO es mandatorio para el insumo --}}
                                    <template x-if="!isLoteRequiredForEntrada()">
                                        {{-- No se puede ni escribir ni seleccionar. Mostramos un input deshabilitado o un texto. --}}
                                        <input type="text" :id="'salida_lote_na_'+index"
                                            placeholder="N/A (Sin control de lote)" {{-- Placeholder para indicar por qué está deshabilitado --}}
                                            x-init="$el.value = salida.lote = ''" {{-- Forzar a vacío y limpiar el modelo --}}
                                            disabled
                                            class="w-full bg-blue-800 border-blue-700 text-blue-500 rounded-md p-1.5 text-xs cursor-not-allowed italic">
                                        {{-- O podrías simplemente no renderizar ningún input y asegurar que 'salida.lote' sea null/vacío en el JS --}}
                                        {{-- Ejemplo: <p class="p-1.5 text-xs text-blue-500 italic">N/A (Sin control de lote)</p> --}}
                                    </template>
                                </div>
                                {{-- Observación --}}
                                <div class="sm:col-span-3">
                                    <label :for="'salida_obs_'+index" class="block text-xs text-blue-300 mb-1">Observ.</label>
                                    <input type="text"
                                        :id="'salida_obs_'+index"
                                        x-model="salida.observacion"
                                        :list="'salida_obs_options_datalist_'+index" {{-- Atributo list que apunta al ID del datalist --}}
                                        placeholder="Escriba o seleccione una opción"
                                        class="w-full bg-blue-700 border-blue-600 rounded-md p-1.5 text-xs focus:ring-cyan-500 focus:border-cyan-500">
                                    <datalist :id="'salida_obs_options_datalist_'+index"> {{-- Datalist con opciones dinámicas --}}
                                        {{-- Iteramos sobre las opciones generadas por la nueva función getSalidaObservationOptions --}}
                                        {{-- Pasamos la fecha de la salida actual para generar la opción de fecha dinámica --}}
                                        <template x-for="option in getSalidaObservationOptions(salida.fecha)" :key="option">
                                            <option :value="option" x-text="option"></option>
                                        </template>
                                    </datalist>
                                </div>
                                {{-- Botón Eliminar Fila --}}
                                <div class="sm:col-span-1 flex items-end justify-end sm:justify-center">
                                    <button @click="removeSalidaRow(index)" title="Eliminar esta fila"
                                            class="p-1.5 bg-red-600 hover:bg-red-500 rounded-md text-white"
                                            x-show="newSalidas.length > 0"> {{-- No mostrar si es la única y quieres que siempre haya al menos una (ajusta esta lógica) --}}
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </template>

                        {{-- Botón Añadir Fila de Salida --}}
                        <div class="text-right pt-1" x-show="newSalidas.length < MAX_SALIDAS">
                            <button @click="addSalidaRow()"
                                    class="px-3 py-1.5 bg-cyan-600 hover:bg-cyan-500 text-white text-xs font-medium rounded-md shadow transition">
                                <i class="fas fa-plus mr-1"></i> Añadir Fila Salida
                            </button>
                        </div>
                        <p x-show="newSalidas.length >= MAX_SALIDAS" class="text-xs text-center text-yellow-400">Límite de 5 salidas alcanzado.</p>
                    </div>

                    {{-- ***** Pestaña de ENTRADAS ***** --}}
                    <div x-show="createModalTab === 'entradas'" class="space-y-3">
                        {{-- Fecha --}}
                        <div>
                            <label for="entrada_fecha" class="block text-sm text-blue-300 mb-1">Fecha <span class="text-red-400">*</span></label>
                            <input type="date" id="entrada_fecha" x-model="newEntrada.fecha" 
                            :min="minDateForCurrentMonth" :max="maxDateForCurrentMonth"
                            class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                        </div>
                        {{-- Cantidad Entrada --}}
                        <div>
                            <label for="entrada_cant" class="block text-sm text-blue-300 mb-1">Cant. Entrada <span class="text-red-400">*</span></label>
                            <input type="number" id="entrada_cant" x-model.number="newEntrada.cantEntrada" placeholder="0" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                        </div>
                        {{-- Factura/Boleta --}}
                        <div>
                            <label for="entrada_factura" class="block text-sm text-blue-300 mb-1">Factura/Boleta</label>
                            <input type="text" id="entrada_factura" x-model="newEntrada.factu_o_boleta" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                        </div>
                        {{-- Observación --}}
                        <div>
                            <label for="entrada_obs" class="block text-sm text-blue-300 mb-1">Observación <span class="text-red-400">*</span></label>
                            <input type="text" id="entrada_obs" x-model="newEntrada.observacion" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                        </div>
                        {{-- Lote --}}
                        <div>
                            <template x-if="isLoteRequiredForEntrada()">
                            <div>
                                <label for="entrada_lote_input" class="block text-sm text-blue-300 mb-1">
                                    Lote <span class="text-red-400">*</span> {{-- El asterisco solo si es mandatorio --}}
                                </label>

                                <input type="text"
                                    id="entrada_lote_input"
                                    x-model="newEntrada.lote"
                                    list="lotes_existentes_para_entrada_datalist" {{-- Vincula al datalist --}}
                                    placeholder="Seleccione o ingrese nuevo lote"
                                    class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">

                                {{-- Datalist con TODOS los lotes existentes de stockPorLoteData para este insumo/almacén/periodo --}}
                                <datalist id="lotes_existentes_para_entrada_datalist">
                                    {{-- Iteramos sobre stockPorLoteData directamente, que tiene todos los lotes del mes/año actual para el insumo --}}
                                    {{-- Asegúrate que stockPorLoteData contenga objetos con 'lote' y 'stock_consolidado' --}}
                                    <template x-for="itemLote in stockPorLoteData.filter(sl => sl.lote)" :key="itemLote.lote + '_entrada_dl_option'">
                                        <option :value="itemLote.lote"
                                                x-text="itemLote.lote + (itemLote.stock_consolidado !== undefined ? ` (Stock: ${itemLote.stock_consolidado})` : '')">
                                        </option>
                                    </template>
                                </datalist>

                                <p class="text-xxs text-blue-400 mt-0.5">
                                    Seleccione un lote de la lista o escriba uno nuevo. Requerido para este insumo.
                                </p>
                                </div>
                            </template>
                        </div>
                        {{-- Proveedor --}}
                        <div>
                            <label for="entrada_proveedor" class="block text-sm text-blue-300 mb-1">Proveedor</label>
                            <input type="text" id="entrada_proveedor" x-model="newEntrada.proveedor" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                        </div>
                    </div>
                </div>

                {{-- Pie del Modal (Botones Guardar/Cancelar) --}}
                <div class="flex justify-end p-4 sm:p-5 space-x-3 border-t border-blue-700">
                    <button @click="closeCreateModal()"
                            :disabled="isSavingMovement"
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition text-sm font-medium disabled:opacity-70">
                        Cancelar
                    </button>
                    <button @click="saveMovements()"
                            :disabled="isSavingMovement"
                            class="inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-500 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50 transition text-sm font-medium disabled:opacity-70 disabled:bg-green-400">
                        <i x-show="isSavingMovement" class="fas fa-spinner fa-spin -ml-1 mr-2 h-4 w-4"></i>
                        <span x-text="isSavingMovement ? 'Guardando...' : 'Guardar'"></span>
                    </button>
                </div>
            </div>
        </div>

        <?php   
        #endregion
        ?>

        <?php   
        #region 🧩Editar
        ?>


        <div x-show="showEditModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            @keydown.escape.window="closeEditModal()"
            class="fixed inset-0 z-40 overflow-y-auto p-4 bg-gray-900 bg-opacity-60 flex items-center justify-center"
            style="display: none;">

            <div @click.outside="closeEditModal()" class="bg-blue-900 text-white rounded-lg shadow-xl w-full max-w-lg md:max-w-xl max-h-[90vh] flex flex-col">

                {{-- Encabezado del Modal --}}
                <div class="flex justify-between items-center p-4 sm:p-5 border-b border-blue-700">
                    <h3 class="text-lg sm:text-xl font-semibold">
                        Editar Movimiento (<span x-text="editingMovementData.tipo_movimiento" class="capitalize"></span>)
                    </h3>
                    <button @click="closeEditModal()" class="text-blue-300 hover:text-white transition text-2xl">&times;</button>
                </div>

                {{-- Contenido del Formulario (overflow para el contenido interno) --}}
                <div class="p-4 sm:p-6 space-y-3 sm:space-y-4 overflow-y-auto flex-grow">
                    {{-- ID del Movimiento (solo informativo, no editable) --}}
                    <p class="text-xs text-blue-400">Editando Movimiento ID: <span x-text="editingMovementData.idMovimiento"></span></p>

                    {{-- Fecha --}}
                    <div>
                        <label for="edit_fecha" class="block text-sm text-blue-300 mb-1">Fecha <span class="text-red-400">*</span></label>
                        <input type="date" id="edit_fecha" x-model="editingMovementData.fecha" 
                        :min="minDateForCurrentMonth" :max="maxDateForCurrentMonth"
                        class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                    </div>

                    {{-- Cantidad Movida --}}
                    <div>
                        <label for="edit_cant_movida" class="block text-sm text-blue-300 mb-1">Cantidad <span class="text-red-400">*</span></label>
                        <input type="number" id="edit_cant_movida" x-model.number="editingMovementData.cant_movida" placeholder="0" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                    </div>

                    {{-- Observación --}}
                    <div>
                        <label for="edit_observacion" class="block text-sm text-blue-300 mb-1">
                            Observación <span x-show="editingMovementData.tipo_movimiento === 'entrada'" class="text-red-400">*</span> {{-- Solo obligatorio para entradas (ejemplo) --}}
                        </label>
                        <input type="text" id="edit_observacion" x-model="editingMovementData.observacion" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                    </div>

                    {{-- Lote --}}
                    <template x-if="isLoteRequiredForEntrada()">
                        <div>
                            <label for="edit_lote" class="block text-sm text-blue-300 mb-1">Lote <span x-show="isLoteRequiredForEdit()" class="text-red-400">*</span></label>
                            <input type="text" id="edit_lote" x-model="editingMovementData.lote" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                        </div>
                    </template>

                    {{-- Campos específicos para ENTRADAS --}}
                    <template x-if="editingMovementData.tipo_movimiento === 'entrada'">
                        <div class="space-y-3 sm:space-y-4 pt-2 border-t border-blue-700 mt-3 sm:mt-4">
                            <div>
                                <label for="edit_factura_boleta" class="block text-sm text-blue-300 mb-1">Factura/Boleta</label>
                                <input type="text" id="edit_factura_boleta" x-model="editingMovementData.factu_o_boleta" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                            </div>
                            <div>
                                <label for="edit_proveedor" class="block text-sm text-blue-300 mb-1">Proveedor</label>
                                <input type="text" id="edit_proveedor" x-model="editingMovementData.proveedor" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Pie del Modal (Botones Guardar/Cancelar) --}}
                <div class="flex justify-end p-4 sm:p-5 space-x-3 border-t border-blue-700">
                    <button @click="closeEditModal()"
                            :disabled="isUpdatingMovement"
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition text-sm font-medium disabled:opacity-70">
                        Cancelar
                    </button>
                    <button @click="updateMovement()"
                            :disabled="isUpdatingMovement"
                            class="inline-flex items-center justify-center px-4 py-2 bg-orange-500 hover:bg-orange-400 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300 focus:ring-opacity-50 transition text-sm font-medium disabled:opacity-70 disabled:bg-orange-300">
                        <i x-show="isUpdatingMovement" class="fas fa-spinner fa-spin -ml-1 mr-2 h-4 w-4"></i>
                        <span x-text="isUpdatingMovement ? 'Actualizando...' : 'Guardar Cambios'"></span>
                    </button>
                </div>
            </div>
        </div>

        <?php   
        #endregion
        ?>




        



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
            createMovimiento: '/movimiento_almacen/store-movimiento',
             updateMovimiento: '/movimiento_almacen/update-movimiento/{movimientoid}', 
            }
    };
    </script>
</x-app-layout>
