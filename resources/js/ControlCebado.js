export default (config) => ({
    csrfToken: config.csrfToken,
    apiEndpoints: config.apiEndpoints,

    selectedYear: new Date().getFullYear(),
    selectedMonth: new Date().getMonth() + 1,

    isLoadingTable: false,

    init() {
        // Puedes hacer algo al iniciar si lo necesitas
    },

    pagTablecc({ idInsumo }) {
        const year = this.selectedYear;
        const month = this.selectedMonth.toString().padStart(2, '0');
        const fecha = `${year}-${month}-01`;

        const url = `${this.apiEndpoints.apiTable}?insumoid=${idInsumo}&year=${fecha}`;
        window.location.href = url;
    }
});