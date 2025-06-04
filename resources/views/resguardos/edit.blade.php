@extends('layouts.app')

<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-4">
        <div class="ml-4 mt-2">
            <flux:button icon="arrow-left" href="{{ route('resguardos.index') }}"></flux:button>
        </div>
        <h1 class="text-2xl font-bold flex-1 text-center">Editar Resguardo #{{ $resguardo->folio }}</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('resguardos.update', $resguardo->folio) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Card: Buscar y Datos del Colaborador -->
                <div class="border rounded-lg shadow p-4 space-y-6">
                    <!-- Buscar Colaborador -->
                    <div>
                        <div class="flex gap-2">
                            <flux:input label="Buscar Colaborador" type="text" id="colaborador-search" placeholder="Número o nombre"
                                class="flex-1 px-4 py-2 rounded-md" value="{{ $resguardo->colaborador_num }}"></flux:input>
                            <flux:button icon="magnifying-glass" id="buscar-btn">
                                Buscar
                            </flux:button>
                        </div>
                        <div id="colaborador-error" class="text-red-500 mt-2 hidden"></div>
                    </div>

                    <!-- Datos del Colaborador -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold">Datos del Colaborador</h2>
                        <div>
                            <flux:input label="Num Colaborador" type="text" name="colaborador_num" id="claveColab" value="{{ $resguardo->colaborador_num }}" readonly
                                required></flux:input>
                        </div>
                        <div>
                            <flux:input type="text" id="nombreCompleto" label="Nombre Completo" value="{{ $resguardo->colaborador_nombre ?? '' }}" readonly></flux:input>
                        </div>
                        <div>
                         
                            <flux:input type="text" id="Puesto" label="Puesto" value="{{ $detalles['puesto'] ?? '' }}" readonly></flux:input>
                        </div>
                        <div>
                         
                            <flux:input type="text" id="area_limpia" label="Departamento" value="{{ $detalles['departamento'] ?? '' }}" readonly></flux:input>
                        </div>
                        <div>
                         
                            <flux:input type="text" id="sucursal_limpia"  label="Ambiente" value="{{ $detalles['sucursal'] ?? '' }}" readonly></flux:input>
                        </div>
                    </div>
                </div>

                <!-- Card: Detalles del Resguardo -->
                <div class="border rounded-lg shadow p-4 space-y-4">
                    <h2 class="text-lg font-semibold">Datos del Resguardo</h2>
                    
                    <div class="mb-4 flex gap-2">
                        <flux:select id="herramienta-filtro" class="flex-1 px-4 py-2 rounded-md">
                            <option value="id">ID</option>
                        </flux:select>
                        <flux:input type="text" id="herramienta-search" placeholder="Buscar herramienta...(GVRMT-ID)"
                            class="flex-1 px-4 py-2 rounded-md" value="{{ $herramienta->id ?? '' }}"></flux:input>
                        <div class="flex gap-2">
                            <flux:button icon="magnifying-glass" id="buscar-herramienta-btn">Buscar</flux:button>
                            @if(isset($herramienta))
                            <flux:button icon="x-mark" id="eliminar-herramienta-btn" type="button" class="bg-red-500 hover:bg-red-600">
                                Eliminar
                            </flux:button>
                            @endif
                        </div>
                    </div>
                    <div id="herramienta-error" class="text-red-500 mt-2 hidden"></div>

                    <!-- Display current tool information -->
                    @if(isset($herramienta))
                    <div id="herramienta-result" class="p-4 border rounded">
                        <strong>ID:</strong> {{ $herramienta->id }}<br>
                        <strong>Modelo:</strong> {{ $herramienta->modelo }}<br>
                        <strong>Número de Serie:</strong> {{ $herramienta->num_serie }}<br>
                        <strong>Artículo:</strong> {{ $herramienta->articulo }}<br>
                        <strong>Costo:</strong> ${{ $detalles['costo'] ?? 0 }}
                    </div>
                    @else
                    <div id="herramienta-result" class="mt-4"></div>
                    @endif

                    <input type="hidden" name="herramienta_id" id="herramienta_id" value="{{ $herramienta->id ?? '' }}">
                    <div>
                        <flux:input label="Fecha de Resguardo" type="date" name="fecha_captura" class="w-full px-3 py-2 rounded"
                            value="{{ \Carbon\Carbon::parse($resguardo->fecha_captura)->format('Y-m-d') }}" required></flux:input>
                    </div>
                    <div>
                        @if(isset($resguardo) && $resguardo->estatus == 'Cancelado')
                            <flux:select label="Estatus del Resguardo" name="estatus" class="w-full px-3 py-2 rounded">
                                <option value="Cancelado" selected>Cancelado</option>
                                <option value="Resguardo">Resguardo</option>
                            </flux:select>
                        @else
                            {{-- Hidden input to ensure "estatus" is always sent --}}
                            <input type="hidden" name="estatus" value="Resguardo">
                        @endif
                    </div>
                </div>
            </div>
            <div class="mb-6">
                <flux:textarea label="Comentarios" is="textarea" name="comentarios" rows="3" class="w-full px-3 py-2 rounded">
                    {{ $resguardo->comentarios }}
                </flux:textarea>
            </div>

            <div class="flex justify-end gap-4">
                <flux:button href="{{ route('resguardos.index') }}" icon="x-mark"
                    class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    Cancelar
                </flux:button>
                <flux:button icon="document-plus" type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Actualizar Resguardo
                </flux:button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buscarBtn = document.getElementById('buscar-btn');
        const searchInput = document.getElementById('colaborador-search');
        const errorDiv = document.getElementById('colaborador-error');
        const claveColabInput = document.getElementById('claveColab');

        buscarBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const searchValue = searchInput.value.trim();

            if (searchValue.length < 2) {
                errorDiv.textContent = 'Ingrese al menos 2 caracteres';
                errorDiv.classList.remove('hidden');
                return;
            }

            errorDiv.classList.add('hidden');

            fetch(`{{ route('resguardos.buscar') }}?clave=${encodeURIComponent(searchValue)}`)
                .then(response => {
                    if (!response.ok) throw new Error('Error en la búsqueda');
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }

                    claveColabInput.value = data.claveColab;
                    document.getElementById('nombreCompleto').value = data.nombreCompleto;
                    document.getElementById('Puesto').value = data.Puesto || 'No especificado';
                    document.getElementById('sucursal_limpia').value = data.sucursal_limpia || 'No especificada';
                    document.getElementById('area_limpia').value = data.area_limpia || 'No especificada';
                })
                .catch(error => {
                    errorDiv.textContent = error.message;
                    errorDiv.classList.remove('hidden');
                    claveColabInput.value = '';
                    document.getElementById('nombreCompleto').value = '';
                    document.getElementById('Puesto').value = '';
                    document.getElementById('sucursal_limpia').value = '';
                    document.getElementById('area_limpia').value = '';
                });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buscarHerramientaBtn = document.getElementById('buscar-herramienta-btn');
        const eliminarHerramientaBtn = document.getElementById('eliminar-herramienta-btn');
        const filtroSelect = document.getElementById('herramienta-filtro');
        const searchInput = document.getElementById('herramienta-search');
        const errorDiv = document.getElementById('herramienta-error');
        const resultDiv = document.getElementById('herramienta-result');
        const herramientaIdInput = document.getElementById('herramienta_id');

        buscarHerramientaBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const filtro = filtroSelect.value;
            const valor = searchInput.value.trim();

            if (!valor) {
                errorDiv.textContent = 'Ingrese un valor para buscar';
                errorDiv.classList.remove('hidden');
                return;
            }

            errorDiv.classList.add('hidden');
            resultDiv.innerHTML = '';

            fetch(`/herramientas/buscar?filtro=${encodeURIComponent(filtro)}&valor=${encodeURIComponent(valor)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    // Muestra los datos de la herramienta encontrada, incluyendo costo
                    resultDiv.innerHTML = `
                        <div class="p-4 border rounded">
                            <strong>ID:</strong> ${data.id}<br>
                            <strong>Modelo:</strong> ${data.modelo}<br>
                            <strong>Número de Serie:</strong> ${data.num_serie}<br>
                            <strong>Artículo:</strong> ${data.articulo}<br>
                            <strong>Costo:</strong> ${data.costo ? '$' + Number(data.costo).toFixed(2) : 'N/A'}<br>
                        </div>
                    `;
                    // Asigna el id al input oculto
                    herramientaIdInput.value = data.id;
                    
                    // Show the eliminate button if it exists
                    if (eliminarHerramientaBtn) {
                        eliminarHerramientaBtn.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    errorDiv.textContent = error.message;
                    errorDiv.classList.remove('hidden');
                });
        });

        // Add functionality to eliminate button if it exists
        if (eliminarHerramientaBtn) {
            eliminarHerramientaBtn.addEventListener('click', function() {
                resultDiv.innerHTML = '';
                searchInput.value = '';
                herramientaIdInput.value = '';
            });
        }
    });
</script>