{{-- filepath: resources/views/herramientas/create.blade.php --}}
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
                <flux:button icon="arrow-left" onclick="window.history.back()">Volver</flux:button>
        </div>

        <h1 class="text-2xl font-bold flex-1 text-center">Registro de Herramientas</h1>
    </div>
    <form action="{{ route('herramientas.store') }}" method="POST" class="rounded shadow p-6 space-y-4">
        @csrf
        <div>
            <flux:label for="articulo">Nombre/Artículo</flux:label>
            <flux:input id="articulo" name="articulo" required />
        </div>
        <div>
            <flux:label for="modelo">Modelo</flux:label>
            <flux:input id="modelo" name="modelo" required />
        </div>
        <div>
            <flux:select name="unidad" label="Unidad" class="w-full px-3 py-2 rounded" required>
                <option value="Pieza" {{ old('unidad') == 'Pieza' ? 'selected' : '' }}>Pieza
                </option>
            </flux:select>
        </div>
        <div>
            <flux:label for="costo">Costo</flux:label>
            <flux:input id="costo" name="costo" type="number" min="0" step="0.01" required />
        </div>

        <div>
            <flux:label for="num_serie">Número de Serie</flux:label>
            <flux:input id="num_serie" name="num_serie" required />
        </div>

        <div>
            <flux:label for="observaciones">Observaciones</flux:label>
            <flux:textarea id="observaciones" name="observaciones" rows="3"></flux:textarea>
        </div>

        <div class="flex justify-end gap-4">
            <flux:button href="{{ url()->previous() }}" icon="x-mark"
                class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                Cancelar
            </flux:button>

            <flux:button icon="document-plus" type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                Guardar Herramienta
            </flux:button>
        </div>
    </form>
</div>
@endsection