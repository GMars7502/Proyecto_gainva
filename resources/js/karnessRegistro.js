

/**
 * Para el registro de insumos, conectado con el archivo almacen/Karness.blade.php
 * 
 * 
 * 
 * 
 */





export default ( config ) => ({
    
        //region VARIABLES
        
        // --- Estado (Propiedades) ---
        insumoId: Number(config.initialInsumoId) || null,
        almacen: config.initialAlmacen || '',
        selectedYear: config.initialYear || new Date().getFullYear(),
        selectedMonth: config.initialMonth || new Date().getMonth() + 1,
        apiEndpoints: config.apiEndpoints || {},
        csrfToken: config.csrfToken || '',


        // >> Datos de Navegación (inicializados desde la config)
        insumoList: config.initialInsumoList || [], // <-- Lista pasada desde Blade
        currentIndex: -1,
        insumoActual: null,
        insumoAnterior: null,
        insumoSiguiente: null,

        // >> Estado de la Tabla
        movimientos: [], // Aquí irán los datos de la tabla
        stockPorLoteData: [], 

        // >> Datos de stock
        totalStock: 0,
        lotesConStock: [], // Aquí se guardarán los lotes con su stock


        // >> Estados de Carga
        isLoadingNav: false, // Realmente no se usa mucho ahora que la lista está pre-cargada
        isLoadingTable: false, // Para la carga de movimientos

        // --- Métodos ---

        /**
         * Función de inicialización (llamada por x-init).
         * Configura el estado inicial de navegación usando la lista ya cargada.
         * Llama a cargar los movimientos iniciales.
         */



        //|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
        //|||||||||||||||||||||||||Variables para modales|||||||||||||||||||||||||||||||||||||||||||||||||
        //|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

        //#Modal eliminar 
        showConfirmDeleteModal: false, // Para controlar la visibilidad del modal
        movementIdToDelete: null,    // Para guardar el ID del movimiento a borrar
        isDeletingMovement: false,

        //#Modal Crear 
        showCreateModal: false,       // Controla la visibilidad del modal de creación
        createModalTab: 'salidas',

                    // Datos para la pestaña de 'Entradas'
        newEntrada: {
            fecha: new Date().toISOString().slice(0,10), // Fecha actual por defecto YYYY-MM-DD
            cantEntrada: '',
            factura: '',
            observacion: '',
            lote: '',
            proveedor: ''
            // Añade otros campos si son necesarios para la entrada
        },

        // Datos para la pestaña de 'Salidas' (array de objetos)
        newSalidas: [
            // Se inicia con una fila por defecto para salidas
            // { fecha: new Date().toISOString().slice(0,10), cantSaca: '', lote: '', observacion: '' }
        ],
        MAX_SALIDAS: 5, // Límite de filas para salidas

        isSavingMovement: false, // Para el estado de carga del botón "Guardar"

        //#Modal Editar

        showEditModal: false,
        editingMovement: null,
        editingMovementData: {
        // idMovimiento: null, // Se tomará del editingMovement
        // fk_insumos: null,
        // almacen: '',
            fecha: '',
            tipo_movimiento: '', 
            cant_movida: '',
            factu_o_boleta: '',
            observacion: '',
            lote: '',
            proveedor: ''
        },

        isUpdatingMovement: false, 


        get minDateForCurrentMonth() {
        const now = new Date();
        // Primer día del mes actual
        const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
        return firstDay.toISOString().slice(0, 10); // Formato YYYY-MM-DD
        },

        get maxDateForCurrentMonth() {
            const now = new Date();
            // Último día del mes actual (yendo al día 0 del mes siguiente)
            const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
            return lastDay.toISOString().slice(0, 10); // Formato YYYY-MM-DD
        },









        //region Inicio

        init() {
    
            console.log('Inicializando karnessRegistro con config:', config);
            if (!this.insumoId || !this.almacen) {
                console.error('Error: Falta ID de insumo inicial o nombre de almacén.');
                // Podrías querer mostrar un error en la UI aquí
                this.insumoActual = { Nombre: 'Error: Configuración inválida' };
                return;
            }
            if (!this.insumoList || this.insumoList.length === 0) {
                console.warn(`La lista inicial de insumos para '${this.almacen}' está vacía o no se cargó.`);
                this.insumoActual = { Nombre: '(Sin Insumos para Navegar)' };
                 // Aún así, intenta cargar movimientos si hay un insumoId válido
            }

            // Configura la navegación inicial
            // Usar el método para navegar al insumo inicial
            this.updateNavigationState();

            // Verificar si el insumo inicial se encontró en la lista
             if (this.currentIndex === -1 && this.insumoList.length > 0) {
                 console.warn(`El insumo inicial ID ${this.insumoId} no se encontró en la lista para el almacén ${this.almacen}. Mostrando datos para ID ${this.insumoId}, pero la navegación puede ser limitada.`);
                 // Se podría asignar un insumo por defecto o dejar el actual como null/error
                 // this.insumoActual = { Nombre: `ID ${this.insumoId} (No en lista)`}; // Ejemplo
             } else if (this.currentIndex === -1) {
                 // Ni la lista existe ni el ID inicial es válido probablemente
                 console.error(`No se pudo determinar el insumo actual.`);
                 this.insumoActual = { Nombre: 'Error al cargar' };
             }


            // >>> ¡Ahora llamamos a fetchMovimientos al iniciar! <<<
            this.navigateToInsumo(this.insumoId); 
        },


        //region Navigation

        /**
         * Actualiza las propiedades insumoActual, insumoAnterior, insumoSiguiente
         * basándose en el insumoId actual y la lista local insumoList.
         */
        updateNavigationState() {
            console.log("[updateNavigationState] Actualizando para insumoId:", this.insumoId);
            if (!this.insumoList || this.insumoList.length === 0) {
                this.currentIndex = -1;
                this.insumoActual = null;
                this.insumoAnterior = null;
                this.insumoSiguiente = null;
                return;
            }

            // Asegúrate que 'idInsumo' sea el nombre correcto de la propiedad ID en tu insumoList
            this.currentIndex = this.insumoList.findIndex(insumo => insumo.idInsumo == this.insumoId); // Usar == para comparación flexible string/número

            if (this.currentIndex !== -1) {
                this.insumoActual = this.insumoList[this.currentIndex];
                this.insumoAnterior = (this.currentIndex > 0) ? this.insumoList[this.currentIndex - 1] : null;
                this.insumoSiguiente = (this.currentIndex < this.insumoList.length - 1) ? this.insumoList[this.currentIndex + 1] : null;
            } else {
                console.warn(`[updateNavigationState] Insumo ID ${this.insumoId} no encontrado en insumoList. Puede ser un ID inicial no presente en la lista filtrada.`);
                // Si el insumoId inicial no está en la lista (ej. si la lista está filtrada y el ID inicial no cumple el filtro),
                // insumoActual podría necesitar obtenerse de otra forma o mostrar un estado especial.
                // Por ahora, si no se encuentra, se limpia la navegación.
                // O podrías intentar buscarlo en config.initialInsumoList si esta fuera diferente o más completa.
                // Asumiendo que initialInsumoList es la fuente de verdad:
                this.insumoActual = null; // O un objeto por defecto: { Nombre: 'Insumo no en lista' }
                this.insumoAnterior = null;
                this.insumoSiguiente = null;
            }
        },

        /**
         * Cambia al insumo con el ID dado, actualiza la navegación y recarga los movimientos.
         * @param {number} newInsumoId El ID del nuevo insumo.
         */
        navigateToInsumo(newInsumoIdValue) {
                const nuevoId = parseInt(newInsumoIdValue, 10); // Convertir a número

                // Prevenir recarga si el ID no es válido o es el mismo que el actual Y no estamos ya cargando
                // Si está cargando, y el usuario intenta cambiar, la nueva solicitud debería tomar precedencia
                // o ser encolada/manejada por la lógica de "ignorar respuestas obsoletas" en fetchMovimientos.
                if (isNaN(nuevoId) || (nuevoId === this.insumoId && !this.isLoadingTable) ) {
                    if (isNaN(nuevoId)) console.warn('[navigateToInsumo] ID inválido:', newInsumoIdValue);
                    // Si el ID es el mismo, simplemente no hacemos nada para evitar recargas innecesarias.
                    // Si el usuario re-selecciona el mismo item, el x-model ya tiene el valor correcto.
                    return;
                }

                // Si se selecciona un nuevo ID válido
                console.log(`[navigateToInsumo] Solicitado para Insumo ID: ${nuevoId} (Anterior: ${this.insumoId})`);
                this.insumoId = nuevoId;          // 1. Actualizar el ID (x-model ya lo hizo si es un <select>)




                console.log(`[navigateToInsumo] Actualizando navegación para Insumo ID: ${nuevoId}`);
                this.updateNavigationState();     // 2. Actualizar insumoActual, Anterior, Siguiente
                this.fetchMovimientos(); 
        },

        /**
         * Formatea una fecha (ej: 'YYYY-MM-DD ...') a un formato más legible (ej: 'DD/MM/YYYY').
         * @param {string} dateString La fecha en formato string.
         */
        formatDate(dateString) {
            if (!dateString) return '';
            try {
                const date = new Date(dateString);
                 // Opciones para formatear. Puedes ajustar 'es-PE' a tu localidad.
                const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                return date.toLocaleDateString('es-PE', options); // Ejemplo: 05/05/2025
            } catch (e) {
                console.error("Error formateando fecha:", dateString, e);
                return dateString; // Devuelve el original si falla
            }
        },



         //region TablaMovi

        //|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
        // --- Métodos para la Tabla de Movimientos (A implementar) ---
        //|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||       
        /**
         * Busca los movimientos para el insumoId, año y mes seleccionados desde la API.
         */
        async fetchMovimientos() {

            console.log('Ingresado al fetchMovimientos');

            const idInsumoSolicitado = this.insumoId;

            if (!idInsumoSolicitado) {
                console.warn("[fetchMovimientos] No hay insumoId seleccionado. Limpiando movimientos.");
                this.movimientos = [];
                this.stockPorLoteData = [];
                this.totalStock = 0;
                this.lotesConStock = [];
                this.isLoadingTable = false; // Asegurar que el loader se apague
                return;
            }

            if (!this.apiEndpoints.getmovimientos) {
                console.error('No se entra al getMovimientos');
                this.isLoadingTable = false;
                return;
            }


            this.isLoadingTable = true;
            


            const url = this.apiEndpoints.getmovimientos.replace('{$insumoId}', this.insumoId);
            const queryParams = new URLSearchParams({
                year: this.selectedYear,
                month: this.selectedMonth,
                almacen: this.almacen // Asegúrate que 'almacen' es un parámetro válido para tu API
                // Podrías añadir 'almacen' si la API lo necesita para filtrar movimientos
                // almacen: this.almacen
            });


            try {
                const response = await fetch(`${url}?${queryParams}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest', // Importante para Laravel
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
               
                
                if (idInsumoSolicitado === this.insumoId) {
                    console.log(`[fetchMovimientos] Aplicando datos para Insumo ID: ${this.insumoId}`);
                    this.movimientos = data.movimientos || [];
                    this.stockPorLoteData = data.stockPorLote || [];

                    console.log("[fetchMovimientos] Datos de movimientos recibidos:", this.movimientos);

                    let sumatotal = 0;
                    let _lotesConStockTemp = [];
                    if (this.stockPorLoteData && Array.isArray(this.stockPorLoteData)) {
                        this.stockPorLoteData.forEach(element => {
                            // Asegúrate que 'element.stock_consolidado' sea el nombre correcto de la propiedad
                            if (element && typeof element.cant_stock === 'number') {
                                sumatotal += element.cant_stock;
                                if (element.lote && element.cant_stock > 0) { // Solo lotes con stock para el desplegable de salidas
                                    _lotesConStockTemp.push({
                                        lote: element.lote,
                                        stock: element.cant_stock // O el nombre que uses en tu desplegable
                                    });
                                }
                            } else {
                                console.warn("[fetchMovimientos] Elemento en stockPorLoteData no tiene 'stock_consolidado' como número:", element);
                            }
                        });
                    }
                    this.totalStock = sumatotal;
                    this.lotesConStock = _lotesConStockTemp;

                    console.log("[fetchMovimientos] Datos de movimientos y stock aplicados. Total stock:", this.totalStock);
                    console.log("[fetchMovimientos] Lotes con stock para salidas:", this.lotesConStock);

                    // Esperar al siguiente "tick" del DOM para que se renderice la tabla
                    // antes de potencialmente ocultar el loader en el 'finally'.
                    await this.$nextTick();
                    console.log('[fetchMovimientos] DOM actualizado después de $nextTick.');

                } else {
                    console.warn(`[fetchMovimientos] Respuesta ignorada para Insumo ID: ${idInsumoSolicitado} porque el insumo actual es ${this.insumoId}.`);
                }

            } catch (error) {
                console.error('Error al buscar movimientos:', error);
                 if (idInsumoSolicitado === this.insumoId) {
                this.movimientos = [];
                this.stockPorLoteData = [];
                this.totalStock = 0;
                this.lotesConStock = [];
                // Considera mostrar un mensaje de error en la UI
                // this.errorTabla = `No se pudieron cargar los movimientos: ${error.message}`;
                 }
            } finally {
                    if (idInsumoSolicitado === this.insumoId) {
                        this.isLoadingTable = false;
                    }
            }
        },

        //region Modales

        // --- Métodos para CRUD de Movimientos (Placeholders) ---





        //********************************************************************************************* */
        //|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
        //|||||||||||||||||||||||||Para modal Crear||||||||||||||||||||||||||||||||||||||||||||||||||||
        //|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
        //********************************************************************************************* */



        openCreateModal() {
        console.log("Abriendo modal de creación...");
        // Resetear los formularios a un estado inicial limpio
        this.createModalTab = 'salidas'; // Pestaña por defecto
        this.newEntrada = {
            fecha: new Date().toISOString().slice(0,10),
            cantEntrada: '',
            factura: '',
            observacion: '',
            lote: '',
            proveedor: ''
        };
        this.newSalidas = [ // Iniciar con una fila vacía para salidas
            { id: Date.now(), fecha: new Date().toISOString().slice(0,10), cantSaca: '', lote: '', observacion: '' }
        ];
        this.isSavingMovement = false;
        this.showCreateModal = true;
        },

        closeCreateModal() {
            this.showCreateModal = false;
            // No es estrictamente necesario resetear aquí si lo hacemos en openCreateModal
        },

        switchCreateTab(tab) {
            if (tab === 'entradas' || tab === 'salidas') {
                this.createModalTab = tab;
                console.log(`Cambiado a pestaña: ${tab}`);
            }
        },

        addSalidaRow() {
            if (this.newSalidas.length < this.MAX_SALIDAS) {
                this.newSalidas.push({
                    id: Date.now(), // Un ID temporal para el :key en x-for
                    fecha: new Date().toISOString().slice(0,10),
                    cantSaca: '',
                    lote: '',
                    observacion: ''
                });
            } else {
                alert(`No se pueden agregar más de ${this.MAX_SALIDAS} salidas a la vez.`);
            }
        },

        removeSalidaRow(indexToRemove) {
            // Usar el índice o un ID único si lo tuvieran los objetos
            this.newSalidas = this.newSalidas.filter((salida, index) => index !== indexToRemove);
        },

        /**
         * Verifica si el campo 'Lote' es requerido para la entrada actual.
         * Asume que 'this.insumoActual.control_cebado' es 'Y' o true.
         */
        isLoteRequiredForEntrada() {
            // Asegúrate que insumoActual exista y tenga la propiedad control_cebado
            if (this.insumoActual && (this.insumoActual.control_cebado === 'Y')) {
                return true;
            }
            return false;
        },

        lotesDisponiblesParaSalida() {
        if (!this.lotesConStock || !Array.isArray(this.lotesConStock)) {
            return [];
        }
        return this.lotesConStock.filter(item => item.lote && item.stock > 0);
        // Asegúrate que 'item.lote' y 'item.stock' sean los nombres correctos de las propiedades.
    },

        saveMovements() {
            this.isSavingMovement = true;
            console.log("Intentando guardar movimientos...");

            let payload = {
                tipo: this.createModalTab, // 'entradas' o 'salidas'
                idInsumo: this.insumoId,
                almacen: this.almacen, // Pasamos el almacén actual
                movimientos: []
            };
            let isValid = true;

            if (this.createModalTab === 'entradas') {
                // Validación para Entrada
                const entrada = this.newEntrada;
                if (!entrada.fecha || !entrada.cantEntrada) { // Quité Observación de obligatorio según tu descripción
                    alert('Para Entradas, la Fecha y Cantidad de Entrada son obligatorias.');
                    isValid = false;
                }
                if (this.isLoteRequiredForEntrada() && !entrada.lote) {
                    alert('Para este insumo, el Lote es obligatorio en las Entradas.');
                    isValid = false;
                }
                if (isValid) {
                    payload.movimientos.push({
                        tipo_movimiento: 'entrada', // Campo para el backend
                        fecha: entrada.fecha,
                        cant_movida: entrada.cantEntrada,
                        factu_o_boleta: entrada.factu_o_boleta, // Nombre de campo para el backend
                        observacion: entrada.observacion,
                        lote: entrada.lote,
                        proveedor: entrada.proveedor
                        // Otros campos que necesite tu API
                    });
                }
            } else { // 'salidas'
                // Validación para Salidas
                if (this.newSalidas.length === 0) {
                    alert('Debe agregar al menos una fila de salida.');
                    isValid = false;
                }
                this.newSalidas.forEach((salida, index) => {
                    if (!salida.fecha || !salida.cantSaca) {
                        alert(`Fila de Salida #${index + 1}: Fecha y Cantidad son obligatorias.`);
                        isValid = false;
                    }
                    // Para salidas, ¿el lote es obligatorio si el insumo tiene control_cebado?
                    // Asumamos que sí por consistencia si el insumo lo requiere.
                    if (this.isLoteRequiredForEntrada() && !salida.lote) { // Reutilizo la función, pero el nombre es engañoso aquí
                        alert(`Fila de Salida #${index + 1}: Para este insumo, el Lote es obligatorio.`);
                        isValid = false;
                    }

                    if (isValid) { // Solo añadir si esta fila es válida (o validar todo antes)
                        payload.movimientos.push({
                            tipo_movimiento: 'salida', // Campo para el backend
                            fecha: salida.fecha,
                            cant_movida: salida.cantSaca,
                            lote: salida.lote,
                            observacion: salida.observacion
                            // Otros campos
                        });
                    }
                });
                if (!isValid) { // Si alguna salida no fue válida, no enviar nada.
                    payload.movimientos = [];
                }
            }

            if (!isValid || payload.movimientos.length === 0) {
                console.log("Validación fallida o no hay movimientos para guardar.");
                this.isSavingMovement = false;
                return; // Detener si hay errores de validación o no hay nada que guardar
            }

            console.log("Payload a enviar:", payload);

            // TODO: Definir el endpoint para crear movimientos en config.apiEndpoints.createMovimiento
            const url = this.apiEndpoints.createMovimiento || '/api/almacen/movimientos'; // Ruta de ejemplo

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify(payload)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.message || 'Error al guardar')});
                }
                return response.json();
            })
            .then(data => {
                alert(data.message || 'Movimiento(s) guardado(s) con éxito.');
                this.fetchMovimientos(); // Recargar la tabla principal
                this.closeCreateModal();
            })
            .catch(error => {
                console.error('Error al guardar movimiento(s):', error);
                alert(`Error: ${error.message}`);
            })
            .finally(() => {
                this.isSavingMovement = false;
            });
        },

        openEditModal(movimiento) {
            console.log("Abrir modal para editar movimiento:", movimiento);
            // Lógica para llenar y mostrar un modal de edición con los datos del movimiento
        },

        openViewModal(movimiento) {
            console.log("Abrir modal para ver movimiento:", movimiento);
            // Lógica para mostrar un modal de visualización (solo lectura)
        },


         /**
         * Calcula la siguiente fecha laborable (omitiendo domingos) a partir de una fecha dada.
         * @param {string} dateString - La fecha de inicio en formato 'YYYY-MM-DD'.
         * @returns {string|null} - La fecha formateada como 'DD/MM/YYYY (I-II-III)' o null si la entrada es inválida.
         */
        getFormattedNextWorkingDay(dateString) {
            if (!dateString) return null;

            try {
                // Parsea la fecha 'YYYY-MM-DD' para evitar problemas de zona horaria con `new Date(string)`
                const parts = dateString.split('-');
                if (parts.length !== 3) return null; // Validación básica del formato

                const year = parseInt(parts[0], 10);
                const month = parseInt(parts[1], 10) - 1; // Mes es 0-indexado en JavaScript Date
                const day = parseInt(parts[2], 10);

                if (isNaN(year) || isNaN(month) || isNaN(day)) return null; // Validación de números

                let targetDate = new Date(year, month, day);
                targetDate.setDate(targetDate.getDate() + 1); // Mover al siguiente día calendario

                // Si el siguiente día es Domingo (getDay() === 0), mover al Lunes
                if (targetDate.getDay() === 0) {
                    targetDate.setDate(targetDate.getDate() + 1);
                }

                // Formatear la fecha a DD/MM/YYYY usando toLocaleDateString (consistente con tu función formatDate)
                const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                const formattedDate = targetDate.toLocaleDateString('es-PE', options);

                return `${formattedDate} (I-II-III)`;

            } catch (e) {
                console.error("Error al calcular la siguiente fecha laborable:", e);
                return null;
            }
        },

        /**
         * Devuelve un array de opciones de observación para una fila de salida.
         * Incluye opciones fijas y una opción dinámica de "fechasiguiente".
         * @param {string} fechaSalida - La fecha de la salida actual (YYYY-MM-DD), usada para calcular la fecha siguiente.
         * @returns {string[]} - Array de strings con las opciones.
         */
        getSalidaObservationOptions(fechaSalida) {
            const fixedOptions = [
                "Limpieza",
                "Kit Emerge"
                // Puedes añadir más opciones fijas aquí si lo necesitas
            ];

            const nextDayOption = this.getFormattedNextWorkingDay(fechaSalida);

            if (nextDayOption) {
                // Poner la fecha siguiente al inicio de la lista para que sea más visible
                return [nextDayOption, ...fixedOptions];
            } else {
                return fixedOptions;
            }
        },

        //********************************************************************************************* */
        //|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
        //|||||||||||||||||||||||||Para modal eliminar|||||||||||||||||||||||||||||||||||||||||||||||||
        //|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
        //********************************************************************************************* */


        closeConfirmDeleteModal() {
            this.showConfirmDeleteModal = false;
            this.movementIdToDelete = null;
            this.isDeletingMovement = false; // Importante resetear esto
        },
    

        confirmDelete(movimientoId) {
            console.log(`Solicitando confirmación para borrar movimiento ID: ${movimientoId}`);
            this.movementIdToDelete = movimientoId;
            this.showConfirmDeleteModal = true; // <--- Esto muestra el modal
            this.isDeletingMovement = false;
        },

        async deleteMovement() {
            const movimientoId = this.movementIdToDelete;
    
            if (!movimientoId) {
                // Esto no debería pasar si el modal se abrió correctamente, pero por si acaso.
                alert('Error: No se ha especificado un ID de movimiento para eliminar.');
                this.closeConfirmDeleteModal();
                return;
            }
    
            if (!this.apiEndpoints.deletemovimiento) {
                alert('Error: Endpoint de borrado no configurado.');
                this.closeConfirmDeleteModal();
                return;
            }
    
            const url = this.apiEndpoints.deletemovimiento.replace('{movimientoid}', movimientoId);
    
            console.log(`Eliminando movimiento ID ${movimientoId} en URL: ${url}`);
            this.isDeletingMovement = true; // <--- Activar estado de carga/spinner
    
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errData => {
                        const error = new Error(errData.message || `Error ${response.status} al eliminar`);
                        error.response = response;
                        throw error;
                    }).catch(() => {
                         const error = new Error(`Error ${response.status}: ${response.statusText}`);
                         error.response = response;
                         throw error;
                    });
                }
                if (response.status === 204) { // No Content
                    return { message: 'Movimiento eliminado con éxito.' }; // Simular un objeto de éxito
                }
                return response.json();
            })
            .then(data => {
                console.log('Respuesta de eliminación:', data);
                // Aquí podrías usar una librería de notificaciones (Toast) en lugar de alert
                alert(data.message || 'Movimiento eliminado con éxito.');
                this.fetchMovimientos(); // Recargar la tabla
            })
            .catch(error => {
                console.error('Error al eliminar movimiento:', error);
                alert(`Error al eliminar: ${error.message || 'Ocurrió un problema.'}`);
            })
            .finally(() => {
                // Esta función se llama siempre, haya éxito o error
                this.closeConfirmDeleteModal(); // <--- Cierra el modal y resetea estados
            });
        },


         //********************************************************************************************* */
        //|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
        //|||||||||||||||||||||||||Para modal Editar|||||||||||||||||||||||||||||||||||||||||||||||||||
        //|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
        //********************************************************************************************* */

        openEditModal(movimiento) {
        console.log("Abriendo modal de edición para:", movimiento);
        if (!movimiento) {
            console.error("Se intentó editar un movimiento nulo.");
            return;
        }
        // Guardar el original para referencia (especialmente el ID)
        this.editingMovement = movimiento;

        // Clonar los datos del movimiento para el formulario
        // y asegurar que los campos del formulario existan.
        this.editingMovementData = {
            idMovimiento: movimiento.idMovimiento, // O como se llame tu PK
            fk_insumos: movimiento.fk_insumos,     // Generalmente no editable
            almacen: movimiento.almacen,         // Generalmente no editable
            fecha: movimiento.fecha ? new Date(movimiento.fecha).toISOString().slice(0,10) : '', // Formato YYYY-MM-DD
            tipo_movimiento: movimiento.tipo_movimiento, // No editable, pero útil para la lógica
            cant_movida: movimiento.cant_movida || '',
            factu_o_boleta: movimiento.factu_o_boleta || '',
            observacion: movimiento.observacion || '',
            lote: movimiento.lote || '',
            proveedor: movimiento.proveedor || ''
            // Copia otros campos editables
        };

        this.isUpdatingMovement = false;
        this.showEditModal = true;
    },

    closeEditModal() {
        this.showEditModal = false;
        this.editingMovement = null;
        this.editingMovementData = { fecha: '', /* ... resetear otros campos ... */ }; // Resetear formulario
    },

    /**
     * Verifica si el campo 'Lote' es requerido al editar,
     * basado en el tipo de movimiento y el control_cebado del insumo.
     */
    isLoteRequiredForEdit() {
        if (this.editingMovementData.tipo_movimiento === 'entrada' && this.insumoActual &&
            (this.insumoActual.control_cebado === 'Y')) {
            return true;
        }
        // Si estás editando una salida y el lote fue obligatorio al crearla (porque control_cebado era Y)
        // quizás quieras mantenerlo como obligatorio o editable.
        // Por simplicidad, lo haremos obligatorio solo para entradas con control_cebado.
        return false;
    },

    updateMovement() {
        if (!this.editingMovement || !this.editingMovementData.idMovimiento) {
            alert('Error: No hay datos de movimiento para actualizar.');
            return;
        }

        this.isUpdatingMovement = true;
        console.log("Intentando actualizar movimiento:", this.editingMovementData);

        // Validación (similar a la de creación, pero para los campos de edición)
        let isValid = true;
        const dataToUpdate = this.editingMovementData;

        if (!dataToUpdate.fecha || !dataToUpdate.cant_movida) {
            alert('Fecha y Cantidad son obligatorias.');
            isValid = false;
        }
        // Si es una entrada, la observación podría ser obligatoria
        if (dataToUpdate.tipo_movimiento === 'entrada' && !dataToUpdate.observacion) {
             // alert('Para Entradas, la Observación es obligatoria.'); // Ajusta según tus reglas
             // isValid = false;
        }

        if (this.isLoteRequiredForEdit() && !dataToUpdate.lote) {
            alert('Para este insumo (tipo entrada), el Lote es obligatorio.');
            isValid = false;
        }

        if (!isValid) {
            this.isUpdatingMovement = false;
            return;
        }

        // Preparamos solo los campos que queremos enviar para la actualización.
        // El backend decidirá qué se puede actualizar realmente.
        const payload = {
            fecha: dataToUpdate.fecha,
            cant_movida: dataToUpdate.cant_movida,
            observacion: dataToUpdate.observacion,
            lote: dataToUpdate.lote,
            // Solo enviar factura y proveedor si es una entrada y tienen valor o son relevantes
            ...(dataToUpdate.tipo_movimiento === 'entrada' && {
                 factu_o_boleta: dataToUpdate.factu_o_boleta,
                 proveedor: dataToUpdate.proveedor
            })
            // NO enviar tipo_movimiento, fk_insumos, almacen si no son editables
        };

        // TODO: Definir el endpoint para actualizar en config.apiEndpoints.updateMovimiento
        const urlTemplate = this.apiEndpoints.updateMovimiento || '/api/almacen/movimientos/{movimientoid}';
        const url = urlTemplate.replace('{movimientoid}', dataToUpdate.idMovimiento);

        console.log("Payload de actualización a enviar:", payload, "a URL:", url);

        fetch(url, {
            method: 'PUT', // O 'PATCH' si solo actualizas campos parciales
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw new Error(err.message || 'Error al actualizar')});
            }
            return response.json();
        })
        .then(data => {
            alert(data.message || 'Movimiento actualizado con éxito.');
            this.fetchMovimientos(); // Recargar la tabla principal
            this.closeEditModal();
        })
        .catch(error => {
            console.error('Error al actualizar movimiento:', error);
            alert(`Error: ${error.message}`);
        })
        .finally(() => {
            this.isUpdatingMovement = false;
        });
    },

        
        

});