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
        <h1 class="text-xl font-semibold text-gray-800">Gestión de Permisos</h1>
    </x-slot>

    <div class="py-12">

        <h1>
            <span class="text-2xl font-bold text-gray-800">Permisos</span>
        </h1>
        
    </div>
</x-app-layout>
