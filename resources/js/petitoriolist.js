

/**
 * Para la muestra de la tabla de los petitorios
 * 
 * 
 * 
 * 
 */

import Swal from 'sweetalert2';

export default (config) => ({
    init() {
        // Aquí puedes inicializar otras cosas
    },

    confirmDelete(formSelector) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                this.$root.querySelector(formSelector).submit();

                


            }
        });
    }
});
