

/**
 * Para la muestra de la tabla de los petitorios
 * 
 * 
 * 
 * 
 */


import Swal from 'sweetalert2';

export default (config) => ({
    fecha_servicio: '',
    status_proceso: 'borrador',
    status_confirmacion: 'N',
    observacion: '',
    insumos: [],
    csrfToken: config.csrfToken || '',

    apiEndpoints: [],

    init() {
        const rawInsumos = window.petitorioInsumos || [];

        this.apiEndpoints = config.apiEndpoints || [];


        console.log('APIENDPOINTS:', this.apiEndpoints);

        this.insumos = rawInsumos.map(insumo => ({
            ...insumo,
            cantidad: 0,
            nombre: insumo.Nombre || '',
            stock: insumo.stock || 0,
            lote1: '', cant1: '',
            lote2: '', cant2: '',
            lote3: '', cant3: '',
            lote4: '', cant4: '',
            observacion: ''
        }));
    },

    limpiar() {
        this.fecha_servicio = '';
        this.observacion = '';

        this.insumos.forEach(item => {
        item.cantidad = 0;
        });
        
        this.insumos.forEach(item => {
            item.cantidad = 0;
            item.lote1 = item.lote2 = item.lote3 = item.lote4 = '';
            item.cant1 = item.cant2 = item.cant3 = item.cant4 = '';
        });
    },

    async guardar() {



        console.log('Petitorio a guardar:', {
            fecha_servicio: this.fecha_servicio,
            status_proceso: this.status_proceso,
            status_confirmacion: this.status_confirmacion,
            observacion: this.observacion,
            insumos: this.insumos
        });

        var url = this.apiEndpoints.createPetitorio;

        var csrfTokenactual = this.csrfToken;

        if(!url && !csrfTokenactual) {

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se ha definido la URL o el Token para crear el petitorio.',
            });
            return;
        }


        if (!this.fecha_servicio) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La fecha de servicio es obligatoria.',
            });
            return;
        }


        const insumos_cant = this.insumos.map(item => ({
                idProducto: item.idInsumo,
                nombre: item.nombre,
                stock: item.stock,
                cantidad_salida: item.cantidad,
                control_lote: item.control_cebado || 'N',
                estado_guardado: 'N',
                movimientos_guardad: []
        }));





        let payload = {
            fecha_servicio: this.fecha_servicio,
            status_proceso: this.status_proceso,
            status_confirmacion: this.status_confirmacion,
            observacion: this.observacion,
            insumos_cant: JSON.stringify(insumos_cant)

        };



            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfTokenactual
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
                            return json; // If OK, return the parsed JSON data
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
                    // This block executes only if the fetch and JSON parsing were successful
                    console.log('Petitorio guardado exitosamente:', data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'El petitorio ha sido guardado exitosamente.',
                    }).then(() => {
                        window.location.href = '/petitorio/';
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


                        
    }
});
