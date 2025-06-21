@extends('layouts.app')
@fluxAppearance

@section('content')
 @if(session('success') || session('error') || $errors->any())
        <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2 w-80">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg toast-message transform transition-all duration-500 ease-in-out hover:shadow-xl">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg toast-message transform transition-all duration-500 ease-in-out hover:shadow-xl">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg toast-message transform transition-all duration-500 ease-in-out hover:shadow-xl">
                    <div class="flex flex-col">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span class="font-semibold">Errores de validación:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toastContainer = document.getElementById('toast-container');
                const toastMessages = document.querySelectorAll('.toast-message');
                
                // Animación de entrada
                toastMessages.forEach((message, index) => {
                    message.style.opacity = '0';
                    message.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        message.style.opacity = '1';
                        message.style.transform = 'translateX(0)';
                    }, 100 + (index * 100)); // Efecto escalonado
                });

                // Auto-cierre después de 5 segundos
                setTimeout(() => {
                    toastMessages.forEach(message => {
                        message.style.opacity = '0';
                        message.style.transform = 'translateX(100%)';
                        setTimeout(() => message.remove(), 500);
                    });
                    
                    // Eliminar contenedor si no hay más mensajes
                    setTimeout(() => {
                        if (toastContainer.querySelectorAll('.toast-message').length === 0) {
                            toastContainer.remove();
                        }
                    }, 500);
                }, 5000);

                // Cierre manual al hacer clic
                toastMessages.forEach(message => {
                    message.addEventListener('click', function() {
                        this.style.opacity = '0';
                        this.style.transform = 'translateX(100%)';
                        setTimeout(() => {
                            this.remove();
                            // Eliminar contenedor si no hay más mensajes
                            if (toastContainer.querySelectorAll('.toast-message').length === 0) {
                                toastContainer.remove();
                            }
                        }, 500);
                    });
                });
            });
        </script>
    @endif
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-4">
        <div class="ml-4 mt-2">
            <flux:button icon="arrow-left" href="{{ route('herramientas.index') }}">Volver </flux:button>
        </div>
        <h1 class="text-2xl font-bold flex-1 text-center">Editar Herramienta #{{ $herramienta->id }}</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif



    <div class="rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('herramientas.update', $herramienta->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="border rounded-lg shadow p-4 space-y-6">
                    <h2 class="text-lg font-semibold">Detalles de la Herramienta</h2>

                    <div>
                        @if($herramienta->estatus == 'Resguardo')
                            <div class="mb-4">
                                <label class="block text-sm font-medium">Estatus</label>
                                <div class="mt-1">
                                    @if($resguardo)
                                        <a href="{{ route('resguardos.show', $resguardo->folio) }}" class="hover:opacity-80">
                                            <flux:badge color="teal" variant="solid" class="inline-block">
                                                Resguardo
                                            </flux:badge>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="mb-4">
                                <label class="block text-sm font-medium">Estatus</label>
                                <div class="mt-1">
                                    <flux:badge color="{{ $herramienta->estatus == 'Baja' ? 'red' : 'green' }}"
                                        variant="solid" class="inline-block">
                                        {{ $herramienta->estatus }}
                                    </flux:badge>
                                </div>
                            </div>
                        @endif
                    </div>
                    <flux:input label="Artículo" name="articulo" :value="$herramienta->articulo" class="w-full" />
                    <flux:input label="Modelo" name="modelo" :value="$herramienta->modelo" class="w-full" />
                    <flux:select name="unidad" class="w-full px-3 py-2 rounded" label="Unidad" required>
                        <option value="Pieza" {{ old('unidad', $herramienta->unidad) == 'Pieza' ? 'selected' : '' }}>Pieza
                        </option>
                    </flux:select>
                    <flux:input label="Número de Serie" name="num_serie" :value="$herramienta->num_serie"
                        class="w-full" />
                    <flux:input label="Costo" name="costo" type="number" :value="$herramienta->costo" class="w-full"
                        placeholder="Ingrese el costo en MXN" />
                </div>


                <div class="border rounded-lg shadow p-4 space-y-4">
                    <h2 class="text-lg font-semibold">Observaciones</h2>
                    <flux:textarea name="observaciones" rows="4" class="w-full">
                        {{ $herramienta->observaciones }}
                    </flux:textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <flux:button href="{{ route('herramientas.index') }}" icon="x-mark"
                    class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    Cancelar
                </flux:button>
                <flux:button icon="document-plus" type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Guardar Cambios
                </flux:button>
            </div>
        </form>
    </div>
</div>

@endsection