
import Swal from 'sweetalert2';

export default (config) => ({


    modalAbierto: false,
    loteActual: {},
    lotesSeleccionados: [],

    abrirModalLote(item) {

        this.loteActual = item;
        this.modalAbierto = true;

        console.log('Lote Actual:', this.loteActual);


        const lotes = config.loteConCantidades[item.idProducto] || [];
        
        this.lotesSeleccionados = lotes.map(l => ({
            lote: l.lote,
            cantidad_disponible: l.cantidad,
            cantidad: 0
        }));

        if (item.lotes_asignados && item.lotes_asignados.length > 0) {
            this.lotesSeleccionados.forEach(modalLote => {
                const assignedLote = item.lotes_asignados.find(
                    assigned => assigned.lote === modalLote.lote
                );
                if (assignedLote) {
                    modalLote.cantidad = assignedLote.cantidad;
                }
            });
        }

    },

    cerrarModalCalcelar(){
        this.modalAbierto = false;
        this.loteActual = {};
        this.lotesSeleccionados = [];
    },


    cerrarModal() {
    if (this.form.status_proceso === 'rectificado') {
        const suma = this.lotesSeleccionados.reduce((acc, l) => acc + Number(l.cantidad), 0);

        if (suma !== Number(this.loteActual.cantidad_salida)) {
            Swal.fire({
                icon: 'warning',
                title: 'Suma de Lotes Incorrecta',
                text: `La suma de las cantidades por lote (${suma}) debe ser igual a la cantidad de salida (${this.loteActual.cantidad_salida}).`,
            });
            return;
        }

        this.loteActual.lotes_asignados = this.lotesSeleccionados.filter(l => Number(l.cantidad) > 0);

        const index = this.form.insumos.findIndex(i => i.idProducto === this.loteActual.idProducto);
        if (index !== -1) {
            this.form.insumos[index] = { ...this.loteActual }; // Reactivo
        }
    }

    this.modalAbierto = false;
    },


 form: {
        id: null,
        fecha_servicio: '',
        status_proceso: '',
        status_confirmacion: '',
        observacion: '',
        insumos: []
    },
    csrfToken: config.csrfToken || '',
    apiEndpoints: config.apiEndpoints || {},
    petitorioRaw: config.petitorio || {},
    loteConCantidades: config.loteConCantidades || {},

    init() {
        // Precarga de datos básicos
        this.form.id = this.petitorioRaw.idpetitorio;
        this.form.fecha_servicio = this.petitorioRaw.fecha_servicio || '';
        this.form.status_proceso = this.petitorioRaw.status_proceso || 'borrador';
        this.form.status_confirmacion = this.petitorioRaw.status_confirmacion || 'N';
        this.form.observacion = this.petitorioRaw.observacion || '';

        // Parsear insumos (vienen en JSON string desde la DB)
        try {
            this.form.insumos = JSON.parse(this.petitorioRaw.insumos_cant || '[]');
            
        } catch (e) {
            console.error('Error al parsear insumos_cant:', e);
            this.form.insumos = [];
        }

        console.log('Petitorio cargado para edición:', this.form);
    },

    guardar() {
        console.log('Datos listos para actualizar:', this.form);
    },



    async guardar(nuevoEstado) {

        if (!nuevoEstado) {
            console.error('Estado nuevo no especificado');
            return;
        }


        console.log('Guardando con nuevo estado:', nuevoEstado);




        var url = this.apiEndpoints.updatePetitorio || '';


        if (url == '' || this.csrfToken  == ''){

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se han definido la url o el token',
            })

            return;

        }





        const insumos_cant = this.form.insumos.map(item => {
                const base = {
                    idProducto: item.idProducto,
                    nombre: item.nombre,
                    stock: item.stock,
                    cantidad_salida: item.cantidad_salida,
                    control_lote: item.control_lote || 'N'
                };

                if (item.control_lote === 'Y') {
                    base.lotes_asignados = item.lotes_asignados || [];
                }

                return base;
            });



        const payload = {
            idpetitorio: this.form.id,
            fecha_servicio: this.form.fecha_servicio,
            status_proceso: nuevoEstado,
            status_confirmacion: this.form.status_confirmacion,
            observacion: this.form.observacion,
            insumos_cant: JSON.stringify(insumos_cant)
        }


        console.log('Payload: ', payload);
        console.log('URL: ', url);


       switch (nuevoEstado) {
        case 'rectificado':


           
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
                                const contentType = response.headers.get('content-type');
                                if (contentType && contentType.includes('application/json')) {
                                    return response.json().then(json => {
                                        if (!response.ok) {
                                            const errorMessage = json.message || (json.errors ? Object.values(json.errors).flat().join('\n') : 'Error desconocido');
                                            throw new Error(errorMessage);
                                        }
                                        return json;
                                    });
                                } else {
                                    return response.text().then(text => {
                                        if (!response.ok) {
                                            throw new Error(text || 'Error inesperado del servidor');
                                        }
                                        return text;
                                    });
                                }
                            })
                            .then(data => {
                                console.log('Petitorio guardado exitosamente:', data);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'El petitorio ha sido guardado exitosamente.',
                                }).then(() => {
                                    window.location.reload();
                                });
                            })
                            .catch(error => {
                                console.error('Error al guardar el petitorio:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: error.message || 'Hubo un problema desconocido al guardar el petitorio.',
                                });
                            });

                        

            
            

            break;
        case 'confirmado':

                    console.log('hola que tal , entrado en confirmado');


                    console.log(payload);
                    console.log(insumos_cant);

                    
                    
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
                                const contentType = response.headers.get('content-type');
                                if (contentType && contentType.includes('application/json')) {
                                    return response.json().then(json => {
                                        if (!response.ok) {
                                            const errorMessage = json.message || (json.errors ? Object.values(json.errors).flat().join('\n') : 'Error desconocido');
                                            throw new Error(errorMessage);
                                        }
                                        return json;
                                    });
                                } else {
                                    return response.text().then(text => {
                                        if (!response.ok) {
                                            throw new Error(text || 'Error inesperado del servidor');
                                        }
                                        return text;
                                    });
                                }
                            })
                            .then(data => {
                                console.log('Petitorio guardado exitosamente:', data);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'El petitorio ha sido guardado exitosamente.',
                                }).then(() => {
                                    window.location.reload();
                                });
                            })
                            .catch(error => {
                                console.error('Error al guardar el petitorio:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: error.message || 'Hubo un problema desconocido al guardar el petitorio.',
                                });
                            });








            break;

        case 'cancelado':


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
                                const contentType = response.headers.get('content-type');
                                if (contentType && contentType.includes('application/json')) {
                                    return response.json().then(json => {
                                        if (!response.ok) {
                                            const errorMessage = json.message || (json.errors ? Object.values(json.errors).flat().join('\n') : 'Error desconocido');
                                            throw new Error(errorMessage);
                                        }
                                        return json;
                                    });
                                } else {
                                    return response.text().then(text => {
                                        if (!response.ok) {
                                            throw new Error(text || 'Error inesperado del servidor');
                                        }
                                        return text;
                                    });
                                }
                            })
                            .then(data => {
                                console.log('Petitorio guardado exitosamente:', data);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'El petitorio ha sido guardado exitosamente.',
                                }).then(() => {
                                    window.location.reload();
                                });
                            })
                            .catch(error => {
                                console.error('Error al guardar el petitorio:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: error.message || 'Hubo un problema desconocido al guardar el petitorio.',
                                });
                            });



            
            break;
        default:

            console.error('Estado no reconocido:', nuevoEstado);

            break;
       }



    



    }




















});