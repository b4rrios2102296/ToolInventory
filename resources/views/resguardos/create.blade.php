@extends('layouts.app')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-4">
        <div class="ml-4 mt-2">
            <flux:button icon="arrow-left" href="{{ route('resguardos.index') }}"></flux:button>
        </div>
        <h1 class="text-2xl font-bold flex-1 text-center">Registro de Resguardo</h1>
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
        <form id="resguardo-form" method="POST" action="{{ route('resguardos.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Card: Buscar y Datos del Colaborador -->
                <div class=" border rounded-lg shadow p-4 space-y-6">
                    <!-- Buscar Colaborador -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Buscar Colaborador</label>
                        <div class="flex gap-2">
                            <flux:input type="text" id="colaborador-search" placeholder="Número o nombre"
                                class="flex-1 px-4 py-2 rounded-md"></flux:input>
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
                            <label class="block text-gray-700">Número</label>
                            <flux:input type="text" name="claveColab" id="claveColab"
                                class="w-full px-3 py-2 rounded bg-gray-100" value="{{ old('claveColab') }}" readonly
                                required></flux:input>
                        </div>
                        <div>
                            <label class="block text-gray-700">Nombre</label>
                            <flux:input type="text" id="nombreCompleto" class="w-full px-3 py-2 rounded bg-gray-100"
                                value="{{ old('nombreCompleto') }}" readonly></flux:input>
                        </div>
                        <div>
                            <label class="block text-gray-700">Puesto</label>
                            <flux:input type="text" id="Puesto" class="w-full px-3 py-2 rounded bg-gray-100"
                                value="{{ old('Puesto') }}" readonly></flux:input>
                        </div>
                        <div>
                            <label class="block text-gray-700">Departamento</label>
                            <flux:input type="text" id="area_limpia" class="w-full px-3 py-2 rounded bg-gray-100"
                                value="{{ old('area_limpia') }}" readonly></flux:input>
                        </div>
                        <div>
                            <label class="block text-gray-700">Ambiente</label>
                            <flux:input type="text" id="sucursal_limpia" class="w-full px-3 py-2 rounded bg-gray-100"
                                value="{{ old('sucursal_limpia') }}" readonly></flux:input>
                        </div>
                    </div>
                </div>

                <!-- Card: Detalles del Resguardo -->
                <div class="border rounded-lg shadow p-4 space-y-4">
                    <h2 class="text-lg font-semibold">Datos del Resguardo</h2>
                    <div class="mb-4 flex gap-2">
                        <flux:select id="herramienta-filtro" class="flex-1 px-4 py-2 rounded-md">
                            <option value="id">ID</option>
                            <option value="modelo">Modelo</option>
                            <option value="num_serie">Número de Serie</option>
                        </flux:select>
                        <flux:input type="text" id="herramienta-search" placeholder="Buscar herramienta..."
                            class="flex-1 px-4 py-2 rounded-md"></flux:input>
                        <flux:button icon="magnifying-glass" id="buscar-herramienta-btn">Buscar</flux:button>
                    </div>
                    <div id="herramienta-error" class="text-red-500 mt-2 hidden"></div>
                    <!-- Aquí puedes mostrar los datos de la herramienta encontrada -->
                    <div id="herramienta-result" class="mt-4"></div>
                    <input type="hidden" name="herramienta_id" id="herramienta_id" value="">
                    <div>
                        <label class="block text-gray-700">Cantidad<span class="text-red-500">*</span></label>
                        <flux:input type="number" name="cantidad" min="1" class="w-full px-3 py-2 rounded"
                            value="{{ old('cantidad', 1) }}" required></flux:input>
                    </div>
                    <div>
                        <label class="block text-gray-700">Fecha de Resguardo <span
                                class="text-red-500">*</span></label>
                        <flux:input type="date" name="fecha_captura" class="w-full px-3 py-2 rounded"
                            value="{{ old('fecha_captura', date('Y-m-d')) }}" required></flux:input>
                    </div>
                    <div>
                        <label class="block text-gray-700">Prioridad <span class="text-red-500">*</span></label>
                        <flux:select name="prioridad" class="w-full px-3 py-2 rounded" required>
                            <option value="Alta" {{ old('prioridad') == 'Alta' ? 'selected' : '' }}>Alta</option>
                            <option value="Media" {{ old('prioridad', 'Media') == 'Media' ? 'selected' : '' }}>Media
                            </option>
                            <option value="Baja" {{ old('prioridad') == 'Baja' ? 'selected' : '' }}>Baja</option>
                        </flux:select>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700">Observaciones</label>
                <flux:textarea is="textarea" name="observaciones" rows="3" class="w-full px-3 py-2 rounded">
                    {{ old('observaciones') }}
                </flux:textarea>
            </div>

            <div class="flex justify-end gap-4">
                <flux:button href="{{ route('resguardos.index') }}" icon="x-mark"
                    class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    Cancelar
                </flux:button>
                <flux:button icon="document-plus" type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Guardar Resguardo
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
        const filtroSelect = document.getElementById('herramienta-filtro');
        const searchInput = document.getElementById('herramienta-search');
        const errorDiv = document.getElementById('herramienta-error');
        const resultDiv = document.getElementById('herramienta-result');

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

            fetch(`{{ route('herramientas.buscar') }}?filtro=${encodeURIComponent(filtro)}&valor=${encodeURIComponent(valor)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    // Muestra los datos de la herramienta encontrada
                    resultDiv.innerHTML = `
        <div class="p-4 border rounded bg-gray-50">
            <strong>ID:</strong> ${data.id}<br>
            <strong>Modelo:</strong> ${data.modelo}<br>
            <strong>Número de Serie:</strong> ${data.num_serie}<br>
            <strong>Artículo:</strong> ${data.articulo}<br>
            <strong>Cantidad:</strong> ${data.cantidad}
        </div>
    `;
                    // Asigna el id al input oculto
                    document.getElementById('herramienta_id').value = data.id;
                })
                .catch(error => {
                    errorDiv.textContent = error.message;
                    errorDiv.classList.remove('hidden');
                });
        });
    });
</script>