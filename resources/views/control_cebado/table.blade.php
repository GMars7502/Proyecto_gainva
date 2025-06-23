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
        <h1 class="text-2xl font-bold text-gray-800">Control Cebado</h1>
    </x-slot>


        <div
        x-data="{
            datos: @js($datosControlCebado),
            isLoadingTable: false,
            totales: { cant1: 0, cant2: 0, cant3: 0, cant4: 0 },
            get totalGeneral() {
                return this.totales.cant1 + this.totales.cant2 + this.totales.cant3 + this.totales.cant4;
            },
            calcularTotales() {
                this.totales = { cant1: 0, cant2: 0, cant3: 0, cant4: 0 };
                this.datos.forEach(item => {
                    this.totales.cant1 += Number(item.cant1) || 0;
                    this.totales.cant2 += Number(item.cant2) || 0;
                    this.totales.cant3 += Number(item.cant3) || 0;
                    this.totales.cant4 += Number(item.cant4) || 0;
                });
            },
            async init() {
                this.isLoadingTable = true;
                // Simulación de carga. Reemplaza esto con una solicitud real si es necesario.
                await new Promise(resolve => setTimeout(resolve, 500)); 
                this.calcularTotales();
                this.isLoadingTable = false;
            }
        }"
        x-init="init()"
        class="overflow-x-auto bg-white shadow-md rounded-lg p-4 relative"
    >


        <div x-show="isLoadingTable" class="absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center z-10">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        </div>
        <table x-show="!isLoadingTable" class="min-w-full divide-y divide-gray-300 text-sm">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Fecha Actual</th>
                    <th class="px-4 py-2 text-left">Fecha Siguiente</th>
                    <th class="px-4 py-2 text-left">Lote 1</th>
                    <th class="px-4 py-2 text-left">Cant 1</th>
                    <th class="px-4 py-2 text-left">Lote 2</th>
                    <th class="px-4 py-2 text-left">Cant 2</th>
                    <th class="px-4 py-2 text-left">Lote 3</th>
                    <th class="px-4 py-2 text-left">Cant 3</th>
                    <th class="px-4 py-2 text-left">Lote 4</th>
                    <th class="px-4 py-2 text-left">Cant 4</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <template x-for="item in datos" :key="item.idControl">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2" x-text="item.actualFecha"></td>
                        <td class="px-4 py-2" x-text="item.siguienteFecha"></td>
                        <td class="px-4 py-2" x-text="item.lote1 ?? ''"></td>
                        <td class="px-4 py-2" x-text="item.cant1 ?? ''"></td>
                        <td class="px-4 py-2" x-text="item.lote2 ?? ''"></td>
                        <td class="px-4 py-2" x-text="item.cant2 ?? ''"></td>
                        <td class="px-4 py-2" x-text="item.lote3 ?? ''"></td>
                        <td class="px-4 py-2" x-text="item.cant3 ?? ''"></td>
                        <td class="px-4 py-2" x-text="item.lote4 ?? ''"></td>
                        <td class="px-4 py-2" x-text="item.cant4 ?? ''"></td>
                        <td class="px-4 py-2">
                            <span
                                class="px-2 py-1 rounded text-xs font-semibold"
                                :class="item.status === 'N' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800'"
                                x-text="item.status"
                            ></span>
                        </td>
                        <td class="px-4 py-2">
                            <form :action="`/control-cebado/status/${item.idControl}`" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="new_status" :value="item.status === 'N' ? 'Y' : 'N'">
                                <button type="submit"
                                    class="text-white bg-blue-500 hover:bg-blue-600 rounded px-3 py-1 text-xs">
                                    Cambiar
                                </button>
                            </form>
                        </td>
                    </tr>
                </template>
            </tbody>

            <!-- Fila de Totales -->
            <tfoot class="bg-gray-100 font-semibold text-gray-800">
                <tr>
                    <td colspan="3" class="px-4 py-2 text-right">Totales:</td>
                    <td class="px-4 py-2" x-text="totales.cant1"></td>
                    <td></td>
                    <td class="px-4 py-2" x-text="totales.cant2"></td>
                    <td></td>
                    <td class="px-4 py-2" x-text="totales.cant3"></td>
                    <td></td>
                    <td class="px-4 py-2" x-text="totales.cant4"></td>
                    <td class="px-4 py-2 font-bold text-blue-600" colspan="2" x-text="`Total general: ${totalGeneral}`"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</x-app-layout>
