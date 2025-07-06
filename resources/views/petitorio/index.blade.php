<x-app-layout>
    <div x-data="PetitorioList()" x-init="init()">
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
        <h1 class="text-xl font-semibold text-gray-800">Gestión de Petitorio</h1>
    </x-slot>

    <div class="py-6">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div x-data="{ search: '' }">
                    <input 
                        type="text" 
                        placeholder="Buscar..." 
                        class="border p-2 mb-4 w-full"
                        x-model="search"
                    >
                @can('petitorio.create')
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('petitorio.create')}}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow transition duration-150 ease-in-out"
                    >
                        <i class="fas fa-plus mr-2"></i> Crear Petitorio
                    </a>
                </div>
                @endcan

                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">codigo</th>
                                <th class="border px-4 py-2">fecha_servicio</th>
                                <th class="border px-4 py-2">fecha_creado</th>
                                <th class="border px-4 py-2">status_proceso</th>
                                <th class="border px-4 py-2">status_confirmacion</th>
                                <th class="border px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listPetitorio as $item)
                                <tr x-show="
                                    [{{ json_encode($item->idpetitorio + 1000) }}, 
                                    '{{ strtolower($item->fecha_servicio ?? '') }}',
                                    '{{ strtolower($item->fecha_creado ?? '') }}',
                                    '{{ strtolower($item->insumos_cant ?? '') }}',
                                    '{{ strtolower($item->status_proceso ?? '') }}',
                                    '{{ strtolower($item->status_confirmacion ?? '') }}']
                                    .some(val => val.toString().toLowerCase().includes(search.toLowerCase()))
                                ">
                                    <td class="border px-4 py-2">{{ $item->idpetitorio + 1000 }}</td>
                                    <td class="border px-4 py-2">{{ $item->fecha_servicio }}</td>
                                    <td class="border px-4 py-2">{{ $item->fecha_creado }}</td>
                                    <td class="border px-4 py-2">{{ $item->status_proceso }}</td>
                                    <td class="border px-4 py-2">{{ $item->status_confirmacion }}</td>
                                    <td class="border px-4 py-2 text-center">

                                        @can('petitorio.show')
                                            <a href="{{ route('petitorio.show', $item->idpetitorio) }}" class="text-blue-500 hover:text-blue-700 ml-2" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan    

                                        @can('petitorio.edit')


                                            @can('petitorio.borrador')
                                                @if ($item->status_proceso === 'borrador')
                                                <a href="{{ route('petitorio.edit', $item->idpetitorio) }}" class="text-yellow-500 hover:text-yellow-700 ml-2" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endif
                                            @endcan

                                            @can('petitorio.rectificador')
                                                @if ($item->status_proceso === 'rectificado')
                                                <a href="{{ route('petitorio.edit', $item->idpetitorio) }}" class="text-yellow-500 hover:text-yellow-700 ml-2" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endif
                                            @endcan

                                            
                                            @can('petitorio.confirmacion')
                                                @if ($item->status_proceso === 'confirmado')
                                                <a href="{{ route('petitorio.edit', $item->idpetitorio) }}" class="text-yellow-500 hover:text-yellow-700 ml-2" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endif
                                            @endcan






                                        @endcan

                                        @can('petitorio.delete')
                                            @if($item->status_proceso === 'borrador'|| $item->status_proceso === 'cancelado')
                                            <form id="form-delete-{{ $item->idpetitorio }}" 
                                                action="{{ route('petitorio.destroy', $item->idpetitorio) }}" 
                                                method="POST" 
                                                class="inline ml-2 delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="button" 
                                                    class="text-red-500 hover:text-red-700 swal-delete-btn" 
                                                    title="Eliminar"
                                                    @click="confirmDelete('#form-delete-{{ $item->idpetitorio }}')"
                                                >
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @endif

                                            @hasrole('Admin')
                                                @if($item->status_proceso === 'confirmado' || $item->status_proceso === 'rectificado')
                                                    <form id="form-delete-{{ $item->idpetitorio }}" 
                                                        action="{{ route('petitorio.destroy', $item->idpetitorio) }}" 
                                                        method="POST" 
                                                        class="inline ml-2 delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button 
                                                            type="button" 
                                                            class="text-red-500 hover:text-red-700 swal-delete-btn" 
                                                            title="Eliminar"
                                                            @click="confirmDelete('#form-delete-{{ $item->idpetitorio }}')"
                                                        >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endif



                                            @endhasrole


                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                

        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true
                });
            @endif
        });
    </script>

</div>
</x-app-layout>