







export default ( config ) => ({
    
        //region VARIABLES
        
        // --- Estado (Propiedades) ---
        insumoId: config.initialInsumoId || null,
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
        MAX_SALIDAS: 10, // Límite de filas para salidas

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
            factura_boleta: '',
            observacion: '',
            lote: '',
            proveedor: ''
        },

        isUpdatingMovement: false, 









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
            this.fetchMovimientos();
        },


        //region Navigation

        /**
         * Actualiza las propiedades insumoActual, insumoAnterior, insumoSiguiente
         * basándose en el insumoId actual y la lista local insumoList.
         */
        updateNavigationState() {
             console.log("Actualizando estado de navegación para insumoId:", this.insumoId);
            if (!this.insumoList || this.insumoList.length === 0) {
                this.currentIndex = -1;
                this.insumoActual = null;
                this.insumoAnterior = null;
                this.insumoSiguiente = null;
                 console.log("Lista de insumos vacía, navegación desactivada.");
                return;
            }

            // AJUSTE: Asegúrate que la propiedad es 'idInsumo' si ese es el nombre en el modelo/JSON
            this.currentIndex = this.insumoList.findIndex(insumo => insumo.idInsumo == this.insumoId); // Comparación flexible con == por si acaso

            if (this.currentIndex !== -1) {
                this.insumoActual = this.insumoList[this.currentIndex];
                this.insumoAnterior = (this.currentIndex > 0) ? this.insumoList[this.currentIndex - 1] : null;
                this.insumoSiguiente = (this.currentIndex < this.insumoList.length - 1) ? this.insumoList[this.currentIndex + 1] : null;
                console.log('Estado de navegación actualizado:', { actual: this.insumoActual?.Nombre, anterior: this.insumoAnterior?.Nombre, siguiente: this.insumoSiguiente?.Nombre });
            } else {
                console.warn(`Insumo ID ${this.insumoId} no encontrado en insumoList.`);
                // Mantenemos el insumoId pero indicamos que no está en la lista navegable
                // Si insumoActual ya fue cargado por el controlador, no lo sobrescribas aquí a menos que sea necesario
                 if (!this.insumoActual) { // Solo si no tenemos nada aún
                     this.insumoActual = { Nombre: `Insumo ID ${this.insumoId} (Fuera de lista)` };
                 }
                this.insumoAnterior = null;
                this.insumoSiguiente = null;
            }
        },

        /**
         * Cambia al insumo con el ID dado, actualiza la navegación y recarga los movimientos.
         * @param {number} newInsumoId El ID del nuevo insumo.
         */
        navigateToInsumo(newInsumoId) {
            if (!newInsumoId || newInsumoId == this.insumoId) return; // Evitar recargas innecesarias

            console.log(`Navegando al insumo ID: ${newInsumoId}`);
            this.insumoId = newInsumoId;      // 1. Actualizar el ID
            this.updateNavigationState();    // 2. Actualizar UI de navegación (anterior/siguiente/actual)
            this.fetchMovimientos();         // 3. Recargar la tabla de movimientos para el nuevo insumo

            // Opcional: Actualizar URL del navegador para reflejar el nuevo estado
            // const newUrl = `/almacen/karness/${this.almacen}/${this.insumoId}`; // Ajusta la ruta base si es necesario
            // window.history.pushState({ insumoId: this.insumoId }, '', newUrl);
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
            console.log("Entrado al fetchMovimientos con insumoId:", this.insumoId);
            if (!this.insumoId) {
                console.log("fetchMovimientos - No hay insumoId seleccionado.");
                this.movimientos = [];
                return;
            }
            if (!this.apiEndpoints.getmovimientos) {
                 console.error("Endpoint 'getMovimientos' no configurado.");
                 return;
            }

            this.isLoadingTable = true;
            this.movimientos = []; // Limpiar tabla mientras carga

            // Construir la URL reemplazando el placeholder y añadiendo query params
            console.log("ESTA ES LA URL: ", this.apiEndpoints.getmovimientos)
            const url = this.apiEndpoints.getmovimientos.replace('{$insumoId}', this.insumoId);
            const queryParams = new URLSearchParams({
                year: this.selectedYear,
                month: this.selectedMonth,
                // Podrías añadir 'almacen' si la API lo necesita para filtrar movimientos
                // almacen: this.almacen
            });

            console.log(`Workspaceing movimientos from: ${url}?${queryParams}`);

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
                this.movimientos = data; // Asume que la API devuelve un array de movimientos
                console.log("Movimientos recibidos:", this.movimientos);

            } catch (error) {
                console.error('Error al buscar movimientos:', error);
                this.movimientos = []; // Dejar tabla vacía en caso de error
                // Podrías añadir una variable de estado para mostrar un mensaje de error en la UI
                // this.errorTabla = 'No se pudieron cargar los movimientos.';
            } finally {
                this.isLoadingTable = false;
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

        saveMovements() {
            this.isSavingMovement = true;
            console.log("Intentando guardar movimientos...");

            let payload = {
                tipo: this.createModalTab, // 'entradas' o 'salidas'
                insumo_id: this.insumoId,
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
                        factura_boleta: entrada.factura, // Nombre de campo para el backend
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
            factura_boleta: movimiento.factura_boleta || '',
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
                 factura_boleta: dataToUpdate.factura_boleta,
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