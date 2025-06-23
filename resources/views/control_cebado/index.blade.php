<x-app-layout>



    <div x-data="ControlCebado(window.Config)"
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
        <h1 class="text-xl font-semibold text-gray-800">Gestión de Cebado</h1>
    </x-slot>



    {{-- Selectores --}}
        <div class="flex flex-wrap justify-center gap-6 sm:gap-10 items-end bg-white p-5 rounded-lg shadow">
            <div>
                <label for="karness-year" class="block text-sm sm:text-base font-medium text-blue-900 mb-1 sm:mb-2">Año</label>
                <select id="karness-year"
                        x-model="selectedYear"
                        @change="recallTotales()"
                        class="bg-white border border-blue-300 text-blue-900 font-semibold px-4 sm:px-6 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        :disabled="isLoadingTable">
                    @for ($year = 2020; $year <= now()->year; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="karness-month" class="block text-sm sm:text-base font-medium text-blue-900 mb-1 sm:mb-2">Mes</label>
                <select id="karness-month"
                        x-model="selectedMonth"
                        @change="recallTotales()"
                        class="bg-white border border-blue-300 text-blue-900 font-semibold px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        :disabled="isLoadingTable">
                    @php
                        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                    @endphp
                    @foreach ($meses as $index => $nombreMes)
                        <option value="{{ $index + 1 }}">{{ $nombreMes }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        {{-- Botones de insumos --}}
        <div>
            @foreach($InsumosConcontrolCebado as $insumoCC)
                <button
                    @click="pagTablecc({ idInsumo: {{ $insumoCC->idInsumo }} })"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200 mb-2">
                    {{ $insumoCC->Nombre }}
                </button>
            @endforeach
        </div>

         <hr>

        <div>
            <p> *Regla Administrativa: El total de filtros deber ser igual a total de Set de lineas por cada mes.</p>
        </div>

        <div class="mt-6 border-t pt-4">
            <h2 class="text-lg font-bold mb-2">Totales por Insumo</h2>

            <div x-show="isLoadingTable" class="flex items-center gap-2 text-blue-600 animate-pulse">
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8v4l5-5-5-5v4a10 10 0 00-10 10h4z"></path>
                </svg>
                Cargando totales...
            </div>

            <template x-for="(item, index) in totalInsumos" :key="index">
                <div class="flex justify-between border-b py-1 text-sm text-gray-700">
                    <span x-text="item.InsumoNombre"></span>
                    <span x-text="item.CantTotal"></span>
                </div>
            </template>
        </div>





    

    </div>

    <script>

        window.Config = {
            csrfToken: '{{ csrf_token() }}',
            apiEndpoints: {
                apiTable: '{{ route('control_cebado.table') }}',
                getTotales: '{{ route('control_cebado.ruleFiltrosSet') }}'
            },
        };




    </script>




</x-app-layout>