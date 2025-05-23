<div class="container mx-auto p-6 space-y-6">

    <!-- Selector de almacén -->
    <div class="bg-white shadow-md p-5 rounded-lg">
        <label class="block font-semibold text-lg text-gray-700">Inventario :</label>
        <select  wire:change="loadKarness" wire:model.live='inventario' class="w-full md:w-1/3 p-3 border rounded-md focus:ring focus:ring-blue-300">
            <option value="Total">Inventario Total</option>
            <option value="Principal">Inventario Principal</option>
            <option value="Secundario">Inventario Secundario</option>
        </select>
    </div>

    <!-- Tarjetas de Karness -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($karness as $kar)
            <div  wire:key="kar-{{ $kar->id }}" class="bg-blue-900 text-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold">Karness {{ $kar->nombre }}</h2>
                <ul class="mt-3 space-y-1">
                    @foreach ($kar->insumos as $insumo)
                        <li>
                            <a href="{{ route('almacen.karness', ['insumoId' => $insumo->idInsumo, 'almacen' => $inventario]) }}" class="block text-sm opacity-80 hover:opacity-100 hover:text-yellow-300 transition">
                                {{ $insumo->Nombre }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
    
</div>
