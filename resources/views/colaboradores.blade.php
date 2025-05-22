
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Registro de Resguardo</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
    @fluxAppearance
    @livewireStyles
    @fluxStyles
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Buscar Colaborador</label>
                <div class="flex gap-2">
                    <input type="text" id="colaborador-search" placeholder="Número o nombre"
                        class="flex-1 px-4 py-2 border rounded-md">
                    <button id="buscar-btn" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                        Buscar
                    </button>
                </div>
                <div id="colaborador-error" class="text-red-500 mt-2 hidden"></div>
            </div>

            <form id="resguardo-form" method="POST" action="{{ route('resguardos.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Datos del Colaborador -->
                    <div class="space-y-4 border p-4 rounded-md">
                        <h2 class="text-lg font-semibold">Datos del Colaborador</h2>
                        <div>
                            <label class="block text-gray-700">Número</label>
                            <input type="text" name="claveColab" id="claveColab"
                                class="w-full px-3 py-2 border rounded bg-gray-100" readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700">Nombre</label>
                            <input type="text" id="nombreCompleto" class="w-full px-3 py-2 border rounded bg-gray-100"
                                readonly>   
                        </div>
                        <div>
                            <label class="block text-gray-700">Puesto</label>
                            <input type="text" id="puesto" class="w-full px-3 py-2 border rounded bg-gray-100" readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700">Área</label>
                            <input type="text" id="area" class="w-full px-3 py-2 border rounded bg-gray-100" readonly>
                        </div>
                    </div>

                    <!-- Datos del Resguardo -->
                    <div class="space-y-4 border p-4 rounded-md">
                        <h2 class="text-lg font-semibold">Datos del Resguardo</h2>
                        <div>
                            <label class="block text-gray-700">Herramienta/Equipo</label>
                            <select name="GVRMT" class="w-full px-3 py-2 border rounded" required>
                                @foreach ($herramientas as $herramienta)
                                    <option value="{{ $herramienta->GVRMT }}">{{ $herramienta->articulo }}
                                        ({{ $herramienta->modelo }})</option>
                                @endforeach
                            </select>

                        </div>
                        <div>
                            <label class="block text-gray-700">Cantidad</label>
                            <input type="number" name="cantidad" min="1" class="w-full px-3 py-2 border rounded" required>
                        </div>
                        <div>
                            <label class="block text-gray-700">Fecha de Entrega</label>
                            <input type="date" name="fecha_entrega" class="w-full px-3 py-2 border rounded" required>
                        </div>
                        <div>
                            <label class="block text-gray-700">Fecha de Captura</label>
                            <input type="date" name="fecha_captura" class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Prioridad</label>
                            <select name="prioridad" class="w-full px-3 py-2 border rounded" required>
                                <option value="Alta">Alta</option>
                                <option value="Media" selected>Media</option>
                                <option value="Baja">Baja</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700">Observaciones</label>
                    <textarea name="observaciones" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Guardar Resguardo
                    </button>
                </div>
            </form>
        </div>
    </div>
    @livewireScripts
    @fluxScripts
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buscarBtn = document.getElementById('buscar-btn');
            const searchInput = document.getElementById('colaborador-search');
            const errorDiv = document.getElementById('colaborador-error');

            buscarBtn.addEventListener('click', function () {
                const searchValue = searchInput.value.trim();

                if (searchValue.length < 2) {
                    errorDiv.textContent = 'Ingrese al menos 2 caracteres';
                    errorDiv.classList.remove('hidden');
                    return;
                }

                errorDiv.classList.add('hidden');

                fetch(`/buscar-colaborador?clave=${encodeURIComponent(searchValue)}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Error en la búsqueda');
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('claveColab').value = data.claveColab;
                        document.getElementById('nombreCompleto').value = data.nombreCompleto;
                        document.getElementById('puesto').value = data.Puesto;
                        document.getElementById('area').value = data.area_limpia;
                    })
                    .catch(error => {
                        errorDiv.textContent = error.message;
                        errorDiv.classList.remove('hidden');
                    });
            });
        });
        
    </script>
