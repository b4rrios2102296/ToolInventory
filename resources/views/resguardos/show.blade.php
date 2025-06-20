@extends('layouts.app')
@fluxAppearance

@section('content')
    <div class="flex items-center mb-4">
        <div class="ml-4 mt-2">
            @if(session('from_create'))
                <flux:button href="{{ route('resguardos.index') }}" icon="arrow-left" class="flex items-center">
                    Volver al Listado
                </flux:button>
            @else
                <flux:button onclick="window.history.back()" icon="arrow-left" class="flex items-center">
                    Volver
                </flux:button>
            @endif
        </div>
        <h1 class="text-2xl font-bold flex-1 text-center">Información de Resguardo #{{ $resguardo->folio }}</h1>
    </div>
    @if(session('success') || session('error'))
        <div id="toast-container" class="fixed top-4 right-4 z-50 transition-all duration-500 ease-in-out">
            @if(session('success') || session('error'))
                <div id="toast-container" class="fixed top-4 right-4 z-50 transition-opacity duration-300">
                    @if(session('success'))
                        <div class="toast-message bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-2 shadow">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="toast-message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-2 shadow">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            @endif

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toastContainer = document.getElementById('toast-container');
                const toastMessages = document.querySelectorAll('.toast-message');

                // Mostrar animación de entrada
                toastContainer.style.opacity = '0';
                toastContainer.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    toastContainer.style.opacity = '1';
                    toastContainer.style.transform = 'translateX(0)';
                }, 100);

                // Ocultar después de 5 segundos
                setTimeout(() => {
                    toastMessages.forEach(message => {
                        message.style.opacity = '0';
                        message.style.transform = 'translateX(100%)';
                        message.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    });

                    // Eliminar el contenedor después de la animación
                    setTimeout(() => {
                        toastContainer.remove();
                    }, 500);
                }, 5000); // 5000ms = 5 segundos

                // Opcional: Cerrar al hacer click
                toastMessages.forEach(message => {
                    message.addEventListener('click', function () {
                        this.style.opacity = '0';
                        this.style.transform = 'translateX(100%)';
                        setTimeout(() => {
                            if (toastContainer.querySelectorAll('.toast-message').length === 1) {
                                toastContainer.remove();
                            } else {
                                this.remove();
                            }
                        }, 500);
                    });
                });
            });
        </script>
    @endif

    <div class="rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Card: Datos del Resguardo -->
            <div class="border rounded-lg shadow p-4 space-y-6">
                <h2 class="text-lg font-semibold">Detalles del Resguardo</h2>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Estatus</label>
                    <flux:badge
                        color="{{ $resguardo->estatus == 'Cancelado' ? 'red' : ($resguardo->estatus == 'Resguardo' ? 'teal' : 'gray') }}"
                        variant="solid" class="inline-block">
                        {{ $resguardo->estatus }}
                    </flux:badge>
                </div>
                <flux:input label="Folio" :value="$resguardo->folio" readonly class="w-full" />
                <flux:input label="Realizó Resguardo"
                    :value="($resguardo->aperturo_nombre ?? '') . ' ' . ($resguardo->aperturo_apellidos ?? '')" readonly
                    class="w-full" />
                <flux:input label="Asignado a" :value="$resguardo->asignado_nombre ?? 'No asignado'" readonly
                    class="w-full" />
                <flux:input label="# Colaborador" :value="$resguardo->colaborador_num" readonly class="w-full" />
                <flux:input label="Fecha de Resguardo"
                    :value="\Carbon\Carbon::parse($resguardo->fecha_captura)->format('d/m/Y')" readonly class="w-full" />
            </div>
            <!-- Card: Detalle del Resguardo -->
            <div class="border rounded-lg shadow p-4 space-y-4">
                <h2 class="text-lg font-semibold">Detalle de Resguardo</h2>
                @php
                    $detalles = json_decode($resguardo->detalles_resguardo ?? '[]', true);
                @endphp

                @if(!empty($detalles))
                    <strong>ID:</strong> {{ $detalles['id'] ?? 'N/A' }}<br>
                    <strong>Modelo:</strong> {{ $detalles['modelo'] ?? 'N/A' }}<br>
                    <strong>Número de Serie:</strong> {{ $detalles['num_serie'] ?? 'N/A' }}<br>
                    <strong>Artículo:</strong> {{ $detalles['articulo'] ?? 'N/A' }}<br>
                    <strong>Costo:</strong>
                    {{ isset($detalles['costo']) ? '$' . number_format($detalles['costo'], 2) . ' MXN' : 'N/A' }}<br>
                @else
                    <p class="text-gray-500">No hay detalles disponibles.</p>
                @endif
            </div>
        </div>
        <div class="mb-6">
            <flux:textarea label="Comentarios" is="textarea" name="comentarios" rows="3" class="w-full px-3 py-2 rounded"
                readonly>
                {{ $resguardo->comentarios }}
            </flux:textarea>
        </div>
        <div class="flex justify-end gap-4">
            @if ($resguardo->estatus != 'Cancelado')
                <!-- <flux:button href="{{ route('resguardos.edit', $resguardo->folio) }}" icon="pencil-square"
                                                                                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                                                                        Editar
                                                                                    </flux:button>-->
                <flux:button href="{{ route('resguardo.pdf', ['folio' => $resguardo->folio]) }}" icon="document-arrow-down"
                    target="_blank">
                    Descargar PDF 📄
                </flux:button>
            @endif
        </div>

    </div>
    </div>
@endsection
@if(session('open_pdf'))
    <script>
        // Verificar si SweetAlert2 está cargado
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        } else {
            console.log('Resguardo {{ session('folio') }} creado correctamente');
        }

        // Abrir PDF en nueva pestaña
        window.open("{{ session('pdf_url') }}", '_blank');
    </script>
@endif