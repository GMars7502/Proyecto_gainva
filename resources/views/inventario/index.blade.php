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
        <h1 class="text-xl font-semibold text-gray-800">Gestión de Inventario</h1>
    </x-slot>

    <div class="overflow-x-auto mt-6">
        <table class="min-w-full bg-white border border-gray-200 rounded-md shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left border-b">Nombre Insumo</th>
                    <th class="px-4 py-2 text-left border-b">Cantidad Atendida</th>
                    <th class="px-4 py-2 text-left border-b">Stock Actual</th>
                    <th class="px-4 py-2 text-left border-b">Por Día/Semana</th>
                    <th class="px-4 py-2 text-left border-b">Cant. Días</th>
                    <th class="px-4 py-2 text-left border-b">Fecha Estimada</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr class="hover:bg-gray-50" 
                        x-data="{
                            cant_atencion: {{ $item['cant_atencion'] }},
                            stock: {{ $item['stock'] }},
                            get diasEstimados() {
                                if (this.cant_atencion <= 0) return 0;
                                return Math.round(this.stock / this.cant_atencion);
                            },
                            get fechaEstimada() {
                                let fecha = new Date();
                                fecha.setDate(fecha.getDate() + this.diasEstimados);
                                return fecha.toISOString().split('T')[0];
                            }
                        }">
                        <td class="px-4 py-2 border-b">{{ $item['Nombre'] }}</td>
                        <td class="px-4 py-2 border-b">{{ $item['cant_atencion'] }}</td>
                        <td class="px-4 py-2 border-b">{{ $item['stock'] }}</td>
                        <td class="px-4 py-2 border-b">{{ $item['tipo_cantidad'] }}</td>
                        <td class="px-4 py-2 border-b" x-text="diasEstimados"></td>
                        <td class="px-4 py-2 border-b" x-text="fechaEstimada"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        console.log(@json($data));
    </script>
</x-app-layout>
