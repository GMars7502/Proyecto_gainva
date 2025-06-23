<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Listado de Permisos</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">

                @if ($permisos->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-2">
                        @foreach ($permisos as $permiso)
                            <div class="flex items-center bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg shadow-sm text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 .667.4 2 2 2s2-1.333 2-2-1-2-2-2-2 1.333-2 2zM16 3h4a2 2 0 012 2v14a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                                </svg>
                                {{ $permiso->name }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center">No hay permisos registrados.</p>
                @endif

            </div>
        </div>
    </div>

    {{-- Scroll personalizado (opcional) --}}
    <style>
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background-color: rgba(99, 102, 241, 0.4); /* Indigo */
            border-radius: 3px;
        }
    </style>
</x-app-layout>
