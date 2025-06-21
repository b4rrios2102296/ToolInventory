@extends('layouts.app')
@fluxAppearance
@section('content')
    @if(session('success') || session('error'))
        <div id="toast-container" class="fixed top-4 right-4 z-50 transition-all duration-500 ease-in-out">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-lg toast-message">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 shadow-lg toast-message">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toastContainer = document.getElementById('toast-container');
                const toastMessages = document.querySelectorAll('.toast-message');

                // Animación de entrada
                toastContainer.style.opacity = '0';
                toastContainer.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    toastContainer.style.opacity = '1';
                    toastContainer.style.transform = 'translateX(0)';
                }, 100);

                // Auto-cierre después de 5 segundos
                setTimeout(() => {
                    toastMessages.forEach(message => {
                        message.style.opacity = '0';
                        message.style.transform = 'translateX(100%)';
                        message.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    });
                    setTimeout(() => toastContainer.remove(), 500);
                }, 5000);

                // Cierre manual al hacer clic
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
    <div class="container mx-auto px-4 py-1">
        <div class="flex items-center mb-4">
            <div class="ml-4 mt-2">
                <flux:button icon="arrow-left" onclick="window.history.back()">Volver</flux:button>
            </div>

            <h1 class="text-2xl font-bold flex-1 text-center">Registro de Resguardo</h1>
        </div>

        <!-- Toast Notifications -->
        <!-- Toast Notifications -->
        @if(session('success') || session('error'))
            <div id="toast-container" class="fixed top-4 right-4 z-50 transition-all duration-500 ease-in-out">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-lg toast-message">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 shadow-lg toast-message">
                        {{ session('error') }}
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
                            <div class="flex items-center gap-5 mt-4">
                                <flux:input label="Buscar Colaborador" type="text" id="colaborador-search"
                                    placeholder="Número o nombre" class="flex-grow"></flux:input>
                                <div class="flex flex-col self-end">
                                    <flux:button icon="magnifying-glass" id="buscar-btn">Buscar</flux:button>
                                </div>
                            </div>

                            <div id="colaborador-error" class="text-red-500 mt-2 hidden"></div>
                        </div>
                        <!-- Datos del Colaborador -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold">Datos del Colaborador</h2>
                            <div>
                                <flux:input label="Num Colaborador" type="text" name="claveColab" id="claveColab"
                                    value="{{ old('claveColab') }}" readonly required></flux:input>
                            </div>
                            <div>
                                <flux:input label="Nombre Completo" type="text" id="nombreCompleto"
                                    value="{{ old('nombreCompleto') }}" readonly></flux:input>
                            </div>
                            <div>
                                <flux:input label="Puesto" type="text" id="Puesto" value="{{ old('Puesto') }}" readonly>
                                </flux:input>
                            </div>
                            <div>
                                <flux:input label="Departamento" type="text" id="area_limpia"
                                    value="{{ old('area_limpia') }}" readonly></flux:input>
                            </div>
                            <div>
                                <flux:input label="Ambiente" type="text" id="sucursal_limpia"
                                    value="{{ old('sucursal_limpia') }}" readonly></flux:input>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Detalles del Resguardo -->
                    <div class="border rounded-lg shadow p-4 space-y-4">
                        <h2 class="text-lg font-semibold">Datos del Resguardo</h2>
                        <div class="mb-4 flex gap-2 items-end">
                            <flux:select id="herramienta-filtro" label="Buscar por ID">
                                <option value="id">ID</option>
                            </flux:select>
                            <flux:input type="text" id="herramienta-search" placeholder="Buscar herramienta...(GVRMT-ID)"
                                class="flex-1 px-4  rounded-md"></flux:input>
                            <div class="flex flex-col self-end">
                                <flux:button icon="magnifying-glass" id="buscar-herramienta-btn">Buscar</flux:button>
                            </div>
                        </div>
                        <div id="herramienta-error" class="text-red-500 mt-2 hidden"></div>
                        <div id="herramienta-result" class="mt-4"></div>
                        <input type="hidden" name="herramienta_id" id="herramienta_id" value="">

                        <div>
                            <flux:input type="date" name="fecha_captura" class="w-full px-3 py-2 rounded"
                                label="Fecha del Resguardo" value="{{ old('fecha_captura', date('Y-m-d')) }}" required>
                            </flux:input>
                        </div>
                    </div>

                </div>

                <div class="mb-6">
                    <flux:textarea label="Comentarios" is="textarea" name="comentarios" rows="3"
                        class="w-full px-3 py-2 rounded">
                        {{ old('comentarios') }}
                    </flux:textarea>
                </div>

                <div class="flex justify-end gap-4">
                    <flux:button href="{{ url()->previous() }}" icon="x-mark">
                        Cancelar
                    </flux:button>
                    <flux:button icon="document-plus" type="submit">
                        Guardar Resguardo
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Colaborador
            const buscarBtn = document.getElementById('buscar-btn');
            const searchInput = document.getElementById('colaborador-search');
            const errorDiv = document.getElementById('colaborador-error');
            const claveColabInput = document.getElementById('claveColab');

            function buscarColaborador() {
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
                        if (data.error) throw new Error(data.error);

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
            }

            buscarBtn.addEventListener('click', function (e) {
                e.preventDefault();
                buscarColaborador();
            });

            searchInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    buscarColaborador();
                }
            });

            // Herramienta
            const buscarHerramientaBtn = document.getElementById('buscar-herramienta-btn');
            const filtroSelect = document.getElementById('herramienta-filtro');
            const herramientaInput = document.getElementById('herramienta-search');
            const herramientaError = document.getElementById('herramienta-error');
            const resultDiv = document.getElementById('herramienta-result');

            function buscarHerramienta() {
                const filtro = filtroSelect.value;
                const valor = herramientaInput.value.trim();

                if (!valor) {
                    herramientaError.textContent = 'Ingrese un valor para buscar';
                    herramientaError.classList.remove('hidden');
                    return;
                }

                herramientaError.classList.add('hidden');
                resultDiv.innerHTML = '';

                fetch(`/herramientas/buscar?filtro=${encodeURIComponent(filtro)}&valor=${encodeURIComponent(valor)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) throw new Error(data.error);

                        resultDiv.innerHTML = `
                                <div class="p-4 border rounded">
                                    <strong>ID:</strong> ${data.id}<br>
                                    <strong>Modelo:</strong> ${data.modelo}<br>
                                    <strong>Número de Serie:</strong> ${data.num_serie}<br>
                                    <strong>Artículo:</strong> ${data.articulo}<br>
                                    <strong>Costo:</strong> ${data.costo ? '$' + Number(data.costo).toFixed(2) + ' MXN' : 'N/A'}<br>
                                </div>
                            `;
                        document.getElementById('herramienta_id').value = data.id;
                    })
                    .catch(error => {
                        herramientaError.textContent = error.message;
                        herramientaError.classList.remove('hidden');
                    });
            }

            buscarHerramientaBtn.addEventListener('click', function (e) {
                e.preventDefault();
                buscarHerramienta();
            });

            herramientaInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    buscarHerramienta();
                }
            });
        });
    </script>
@endsection