

export default ( config ) => ({



    Insumoslist: [],
    csrfToken: '',




    init(){

        this.Insumoslist = config.initialInsumoList;

        console.log('InsumosRegistro.js init');

        console.log('Insumoslist', this.Insumoslist);  

    },

    


    //region 😵 Eliminar

    
    showConfirmDeleteModal: false, // Para controlar la visibilidad del modal
    movementIdToDelete: null,    // Para guardar el ID del movimiento a borrar
    isDeletingMovement: false,


    closeConfirmDeleteModal() {
            this.showConfirmDeleteModal = false;
            this.movementIdToDelete = null;
            this.isDeletingMovement = false; // Importante resetear esto
        },
    

        confirmDelete(idInsumo) {
            console.log(`Solicitando confirmación para borrar movimiento ID: ${idInsumo}`);
            this.movementIdToDelete = idInsumo;
            this.showConfirmDeleteModal = true; // <--- Esto muestra el modal
            this.isDeletingMovement = false;
        },

        async deleteMovement() {
            this.isDeletingMovement = true;

            const idInsumo = this.movementIdToDelete;

            const url = config.apiEndpoints.deleteInsumo.replace('__ID__', idInsumo);
            this.csrfToken = config.csrfToken;



            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.message || 'Error al Eliminar')});
                }
                return response.json();
            })
            .then(data => {
                alert(data.message || 'Insumo Eliminado con exito!!.');
            })
            .catch(error => {
                console.error('Error al eliminar insumo:', error);
                alert(`Error: ${error.message}`);
            })
            .finally(() => {
                this.isDeletingMovement = false;
                this.closeConfirmDeleteModal();
            });

            window.location.reload();
    
            
        },





    //region 🥸 editar

        //aquí se agregar el id de lo que quieres editar

        isUpdatingMovement : false,
        showEditModal: false,
        editingMovement: null,
        idInsumoActualizar: '',


        actuInsumo: {
            Nombre: '',
            Descripcion: '',
            idKarness: '',
            control_cebado: '',
            control_emergencia: '',
            almacenPrincipal: '',
            almacenSegundo: '',
        },

        openEditModal(idInsumo) {
            console.log("Abriendo modal de edición para:", idInsumo);

            this.fetchInsumoDetails(idInsumo);
            this.idInsumoActualizar = idInsumo; // Guardar el ID del insumo a actualizar

            this.isUpdatingMovement = false;
            this.showEditModal = true;
        },

        fetchInsumoDetails(idInsumo){

            var Encontrado  = this.Insumoslist.find(insumo => insumo.idInsumo === idInsumo);

            if(!Encontrado){
                console.error(`Insumo con ID ${idInsumo} no encontrado.`);
                return;
            }

            this.actuInsumo = {
                Nombre: Encontrado.Nombre,
                Descripcion: Encontrado.descripcion,
                idKarness: Encontrado.idKarness,
                control_cebado: Encontrado.control_cebado,
                control_emergencia: Encontrado.control_emergencia,
                almacenPrincipal: Encontrado.almacenPrincipal === 'Y',
                almacenSegundo: Encontrado.almacenSegundo === 'Y',
            };


        },



        closeEditModal() {

            this.showEditModal = false;
            this.editingMovement = null;


            this.idInsumoActualizar =  '';
            this.actuInsumo = {
                Nombre: '',
                Descripcion: '',
                idKarness: '',
                control_cebado: '',
                control_emergencia: '',
                almacenPrincipal: '',
                almacenSegundo: ''
            };

            
        },

   
        updateMovement() {

            this.isUpdatingMovement = true;

            const idInsumo = this.idInsumoActualizar;

            const payload = {
                idInsumo: idInsumo,
                Nombre: this.actuInsumo.Nombre,
                descripcion: this.actuInsumo.Descripcion,
                idKarness: this.actuInsumo.idKarness,
                control_cebado: this.actuInsumo.control_cebado,
                control_emergencia: this.actuInsumo.control_emergencia,
                almacenPrincipal: this.actuInsumo.almacenPrincipal ? 'Y' : 'N',
                almacenSegundo: this.actuInsumo.almacenSegundo ? 'Y' : 'N',
            };

            const url = config.apiEndpoints.actualizarInsumo.replace('__ID__', idInsumo);


            this.csrfToken = config.csrfToken;


            fetch(url, {
                method: 'PUT',
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
                alert(data.message || 'Insumo Actualizado con exito!!.');
                this.actuInsumo = {
                    Nombre: '',
                    Descripcion: '',
                    idKarness: '',
                    control_cebado: '',
                    control_emergencia: '',
                    almacenPrincipal: '',
                    almacenSegundo: ''
                };
            })
            .catch(error => {
                console.error('Error al actualizar insumo:', error);
                alert(`Error: ${error.message}`);
            })
            .finally(() => {
                this.isUpdatingMovement = false;
                Livewire.emit('inventarioCambiado', 'nombre_del_inventario');
                this.closeEditModal();
            });

            window.location.reload();

            

            





            
        },


    //endregion



    //region 😍Create

    showCrearModal: false,
    isCreatingInsumo: false,

    newInsumo: {
        Nombre: '',
        Descripcion: '',
        idKarness: '',
        control_cebado: '',
        control_emergencia: '',
        almacenPrincipal: '',
        almacenSegundo: '',
    },

        openCrearModal() {
            this.isCreatingInsumo = false;
            this.showCrearModal = true;
        },



        closeCrearModal() {
            this.showCrearModal = false;
            this.isCreatingInsumo =  false;
        },

   
        async createInsumo() {

           

            this.isCreatingInsumo = true;

            

            const payload = {
                Nombre: this.newInsumo.Nombre,
                descripcion: this.newInsumo.Descripcion,
                idKarness: this.newInsumo.idKarness,
                control_cebado: this.newInsumo.control_cebado,
                control_emergencia: this.newInsumo.control_emergencia,
                almacenPrincipal: this.newInsumo.almacenPrincipal? 'Y' : 'N',
                almacenSegundo: this.newInsumo.almacenSegundo? 'Y' : 'N',
            };

            
            
            const url = config.apiEndpoints.createinsumo;
            this.csrfToken = config.csrfToken;

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
                alert(data.message || 'Insumo guardado con exito!!.');
                this.newInsumo = {
                    Nombre: '',
                    Descripcion: '',
                    idKarness: '',
                    control_cebado: '',
                    control_emergencia: '',
                    almacenPrincipal: '',
                    almacenSegundo: ''
                };
            })
            .catch(error => {
                console.error('Error al guardar movimiento(s):', error);
                alert(`Error: ${error.message}`);
            })
            .finally(() => {
                this.isCreatingInsumo = false;
            });

        

            this.closeCrearModal();
            window.location.reload();

        },












});