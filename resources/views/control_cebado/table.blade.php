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
        <h1 class="text-xl font-semibold text-gray-800">Control Cebado</h1>
    </x-slot>


    <p>Mensaje de prueba: {{$prueba}}</p>

    <script> 
    console.log('{{$datosControlCebado}}');
    </script>







</x-app-layout>