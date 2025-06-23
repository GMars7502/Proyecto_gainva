export default (config) => ({
    csrfToken: config.csrfToken,
    apiEndpoints: config.apiEndpoints,

    selectedYear: new Date().getFullYear(),
    selectedMonth: new Date().getMonth() + 1,

    isLoadingTable: false,
    totalInsumos: [],

    init() {

        this.recallTotales();






    },


    recallTotales(){

        this.isLoadingTable = true;
        this.totalInsumos = [];

        const year = this.selectedYear;
        const month = this.selectedMonth.toString().padStart(2, '0');

        const fecha = `${year}-${month}-01`;

        console.log(this.apiEndpoints.getTotales);

        const url = `${this.apiEndpoints.getTotales}?fecha=${fecha}`;

        fetch(url)
        .then(response => response.json())
        .then(data => {
            this.totalInsumos = data;
            this.isLoadingTable = false;
        })
        .catch(error => {
            console.error('Error al obtener los totales:', error);
            this.isLoadingTable = false;
        });


    },

    pagTablecc({ idInsumo }) {
        const year = this.selectedYear;
        const month = this.selectedMonth.toString().padStart(2, '0');
        const fecha = `${year}-${month}-01`;

        const url = `${this.apiEndpoints.apiTable}?insumoid=${idInsumo}&fecha=${fecha}`;
        window.location.href = url;
    }
});