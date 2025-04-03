<x-app-layout>
    <div class="container mx-auto p-6 space-y-6">
        <!-- Filtros de Año y Mes -->
        <div class="flex justify-center space-x-6 items-center text-gray-800">
            <div class="text-center">
                <label class="block text-lg font-semibold">Año</label>
                <select class="bg-blue-900 text-white px-4 py-2 rounded-md">
                    @for ($year = 2020; $year <= now()->year; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
            
            <div class="text-center">
                <label class="block text-lg font-semibold">Mes</label>
                <select class="bg-blue-900 text-white px-4 py-2 rounded-md">
                    @foreach (['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $mes)
                        <option value="{{ $mes }}">{{ $mes }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Navegación entre insumos -->
        <div class="flex items-center justify-center space-x-4 text-gray-700">
            <a href="#" class="flex items-center space-x-2 hover:text-gray-900">
                <span class="text-2xl">⬅</span>
                <span class="underline">anterior insumo</span>
            </a>
            
            <div class="bg-blue-900 text-white px-6 py-2 rounded-md text-lg font-semibold">
                {{ $id }}
            </div>

            <a href="#" class="flex items-center space-x-2 hover:text-gray-900">
                <span class="underline">siguiente insumo</span>
                <span class="text-2xl">➡</span>
            </a>
        </div>

        <!-- Tabla de registros -->
        <div class="bg-blue-900 text-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-center mb-4">{{ $almacen }}</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white">
                            <th class="py-2 px-4">Fecha</th>
                            <th class="py-2 px-4">Tipo Movimiento</th>
                            <th class="py-2 px-4">Cant. Movida</th>
                            <th class="py-2 px-4">Stock</th>
                            <th class="py-2 px-4">Facturación</th>
                            <th class="py-2 px-4">Observación</th>
                            <th class="py-2 px-4">Lote</th>
                            <th class="py-2 px-4">Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí puedes iterar sobre los datos reales -->
                        <tr class="border-t border-white text-center">
                            <td class="py-3 px-4">--</td>
                            <td class="py-3 px-4">--</td>
                            <td class="py-3 px-4">--</td>
                            <td class="py-3 px-4">--</td>
                            <td class="py-3 px-4">--</td>
                            <td class="py-3 px-4">--</td>
                            <td class="py-3 px-4">--</td>
                            <td class="py-3 px-4">--</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
