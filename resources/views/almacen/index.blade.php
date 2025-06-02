

<?php
$insumo = 'InsumoID'; 

?>

<x-app-layout>
    
    
    <div x-data="InsumosRegistro(window.karnessConfig)"
            x-init="init()"
            class="container mx-auto px-6 py-10 space-y-10 text-gray-800"
        >
    



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
            <h1 class="text-xl font-semibold text-gray-800">Gestión Almacen</h1>
        </x-slot>

            <div>

                <livewire:components.karness-list />
            
            </div>





















        <?php   
        #region 🍔Eliminar 
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
            <div @click.outside="" {{-- Cerrar si se hace clic fuera (opcional) --}}
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
                    <p>¿Estás seguro de que deseas eliminar este Insumo?</p>
                    <p>
                        Esta acción es <span class="text-red-600 font-semibold">irreversible</span> y eliminará todos los datos asociados a este insumo.<br>
                        Será eliminado <span class="text-red-600 font-semibold">permanentemente.☠️</span>
                    </p>
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
        #region 🐶Editar
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

            <div @click.outside="" class="bg-blue-900 text-white rounded-lg shadow-xl w-full max-w-lg md:max-w-xl max-h-[90vh] flex flex-col">

                {{-- Encabezado del Modal --}}
                <div class="flex justify-between items-center p-4 sm:p-5 border-b border-blue-700">
                    <h3 class="text-lg sm:text-xl font-semibold">
                        Editar Insumo
                    </h3>
                    <button @click="closeEditModal()" class="text-blue-300 hover:text-white transition text-2xl">&times;</button>
                </div>

                {{-- Contenido del Formulario (overflow para el contenido interno) --}}
                <div class="p-4 sm:p-6 space-y-3 sm:space-y-4 overflow-y-auto flex-grow">
                    {{-- ID del Movimiento (solo informativo, no editable) --}}
                    <p class="text-xs text-blue-400">Editando Insumo: </p>



                    <div>
                        <label for="NombreInsumo" class="block text-sm text-blue-300 mb-1">Nombre insumo:</label>
                        <input type="text" id="NombreInsumo" x-model="actuInsumo.Nombre" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                    </div>

                    <div>
                        <label for="DescripcionInsumo" class="block text-sm text-blue-300 mb-1">Descripción insumo:</label>
                        <input type="text" id="DescripcionInsumo" x-model="actuInsumo.Descripcion" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                    </div>

                    <div>
                        <label for="select_karness" class="block text-sm text-blue-300 mb-1">Elegir Karness:</label>
                        <select id="select_karness" x-model="actuInsumo.idKarness" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                            <option value="" disabled>Seleccione un Karness</option> {{-- Quité 'selected' para que x-model maneje la selección inicial basada en newInsumo.idKarness --}}
                            <option value="1">Karness Alto</option>
                            <option value="2">Karness Medio</option>
                            <option value="3">Karness Bajo</option>
                            <option value="4">Karness Otro</option>
                        </select>
                    </div> {{-- Cierre del div para Karness --}}

                    <div>
                        <label for="select_cebado" class="block text-sm text-blue-300 mb-1">¿Tendrá Control de cebado?</label>
                        <select id="select_cebado" x-model="actuInsumo.control_cebado" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                            <option value="" disabled>Seleccione una opción</option>
                            <option value="Y">Si</option>
                            <option value="N">No</option>
                        </select>
                    </div> {{-- Cierre del div para Control de cebado --}}

                    <div>
                        <label for="select_emergencia" class="block text-sm text-blue-300 mb-1">¿Tendrá Control de emergencia?</label>
                        <select id="select_emergencia" x-model="actuInsumo.control_emergencia" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                            <option value="" disabled>Seleccione una opción</option>
                            <option value="Y">Si</option>
                            <option value="N">No</option>
                        </select>
                    </div> {{-- Cierre del div para Control de emergencia --}}

                    <div>
                        <label class="block text-sm text-blue-300 mb-1">¿En qué almacén se guardará?</label>
                        {{-- Asumiendo que almacenPrincipal y almacenSegundo son propiedades booleanas en tu data de Alpine --}}
                        {{-- Si deben ser parte de newInsumo, usa x-model="newInsumo.almacenPrincipal", etc. --}}
                        <div>
                            <input x-model="actuInsumo.almacenPrincipal" type="checkbox" id="principal_alma" name="principal" value="Y" class="mr-1 rounded text-cyan-600 focus:ring-cyan-500">
                            <label for="principal_alma" class="text-sm text-white">Alm. Principal</label>
                        </div>
                        <div>
                            <input x-model="actuInsumo.almacenSegundo" type="checkbox" id="secundario_alma" name="secundario" value="Y" class="mr-1 rounded text-cyan-600 focus:ring-cyan-500">
                            <label for="secundario_alma" class="text-sm text-white">Alm. Secundario</label>
                        </div>
                    </div>





                    
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











        <?php   
        #region 😒Crear
        ?>

        <div x-show="showCrearModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            @keydown.escape.window="closeCrearModal()"
            class="fixed inset-0 z-40 overflow-y-auto p-4 bg-gray-900 bg-opacity-60 flex items-center justify-center"
            style="display: none;">

            <div @click.outside="" class="bg-blue-900 text-white rounded-lg shadow-xl w-full max-w-lg md:max-w-xl max-h-[90vh] flex flex-col">

                {{-- Encabezado del Modal --}}
                <div class="flex justify-between items-center p-4 sm:p-5 border-b border-blue-700">
                    <h3 class="text-lg sm:text-xl font-semibold">
                        Crear Insumo
                    </h3>
                    <button @click="closeCrearModal()" class="text-blue-300 hover:text-white transition text-2xl">&times;</button>
                </div>

                {{-- Contenido del Formulario (overflow para el contenido interno) --}}
                <div class="p-4 sm:p-6 space-y-3 sm:space-y-4 overflow-y-auto flex-grow">
                    {{-- ID del Movimiento (solo informativo, no editable) --}}
                   <div>
                        <label for="NombreInsumo" class="block text-sm text-blue-300 mb-1">Nombre insumo:</label>
                        <input type="text" id="NombreInsumo" x-model="newInsumo.Nombre" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                    </div>

                    <div>
                        <label for="DescripcionInsumo" class="block text-sm text-blue-300 mb-1">Descripción insumo:</label>
                        <input type="text" id="DescripcionInsumo" x-model="newInsumo.Descripcion" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                    </div>

                    <div>
                        <label for="select_karness" class="block text-sm text-blue-300 mb-1">Elegir Karness:</label>
                        <select id="select_karness" x-model="newInsumo.idKarness" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                            <option value="" disabled>Seleccione un Karness</option> {{-- Quité 'selected' para que x-model maneje la selección inicial basada en newInsumo.idKarness --}}
                            <option value="1">Karness Alto</option>
                            <option value="2">Karness Medio</option>
                            <option value="3">Karness Bajo</option>
                            <option value="4">Karness Otro</option>
                        </select>
                    </div> {{-- Cierre del div para Karness --}}

                    <div>
                        <label for="select_cebado" class="block text-sm text-blue-300 mb-1">¿Tendrá Control de cebado?</label>
                        <select id="select_cebado" x-model="newInsumo.control_cebado" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                            <option value="" disabled>Seleccione una opción</option>
                            <option value="Y">Si</option>
                            <option value="N">No</option>
                        </select>
                    </div> {{-- Cierre del div para Control de cebado --}}

                    <div>
                        <label for="select_emergencia" class="block text-sm text-blue-300 mb-1">¿Tendrá Control de emergencia?</label>
                        <select id="select_emergencia" x-model="newInsumo.control_emergencia" class="w-full bg-blue-700 border-blue-600 rounded-md p-2 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                            <option value="" disabled>Seleccione una opción</option>
                            <option value="Y">Si</option>
                            <option value="N">No</option>
                        </select>
                    </div> {{-- Cierre del div para Control de emergencia --}}

                    <div>
                        <label class="block text-sm text-blue-300 mb-1">¿En qué almacén se guardará?</label>
                        {{-- Asumiendo que almacenPrincipal y almacenSegundo son propiedades booleanas en tu data de Alpine --}}
                        {{-- Si deben ser parte de newInsumo, usa x-model="newInsumo.almacenPrincipal", etc. --}}
                        <div>
                            <input x-model="newInsumo.almacenPrincipal" type="checkbox" id="principal_alma" name="principal" value="Y" class="mr-1 rounded text-cyan-600 focus:ring-cyan-500">
                            <label for="principal_alma" class="text-sm text-white">Alm. Principal</label>
                        </div>
                        <div>
                            <input x-model="newInsumo.almacenSegundo" type="checkbox" id="secundario_alma" name="secundario" value="Y" class="mr-1 rounded text-cyan-600 focus:ring-cyan-500">
                            <label for="secundario_alma" class="text-sm text-white">Alm. Secundario</label>
                        </div>
                    </div>

                    
                </div>

                {{-- Pie del Modal (Botones Guardar/Cancelar) --}}
                <div class="flex justify-end p-4 sm:p-5 space-x-3 border-t border-blue-700">
                    <button @click="closeCrearModal()"
                            :disabled="isCreatingInsumo"
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition text-sm font-medium disabled:opacity-70">
                        Cancelar
                    </button>
                    <button @click="createInsumo()"
                            :disabled="isCreatingInsumo"
                            class="inline-flex items-center justify-center px-4 py-2 bg-orange-500 hover:bg-orange-400 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300 focus:ring-opacity-50 transition text-sm font-medium disabled:opacity-70 disabled:bg-orange-300">
                        <i x-show="isCreatingInsumo" class="fas fa-spinner fa-spin -ml-1 mr-2 h-4 w-4"></i>
                        <span x-text="isCreatingInsumo ? 'Creando...' : 'Guardar Cambios'"></span>
                    </button>
                </div>
            </div>
        </div>



















        
    

    </div>

    <script>

        window.karnessConfig = {
            csrfToken: '{{ csrf_token() }}',
            initialInsumoList: @json($ListInsumos?? []),
            apiEndpoints: {
                createinsumo: '{{ route('insumos.store') }}',
                actualizarInsumo : '{{ route('insumos.update', ['insumo' => '__ID__']) }}',
                deleteInsumo: '{{ route('insumos.destroy', ['insumo' => '__ID__']) }}',
            },
        };
        
    </script>
    


</x-app-layout>
