@extends('layouts.app')

<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-4">
        <div class="ml-4 mt-2">
            <flux:button icon="arrow-left" href="{{ route('resguardos.index') }}">Volver</flux:button>
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
                        <div class="flex gap-2">
                            <flux:input label="Buscar Colaborador" type="text" id="colaborador-search"
                                placeholder="Número o nombre"></flux:input>
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
                    <div class="mb-4 flex gap-2">
                        <flux:select id="herramienta-filtro" label="Buscar por ID">
                            <option value="id">ID</option>
                        </flux:select>
                        <flux:input type="text" id="herramienta-search" placeholder="Buscar herramienta...(GVRMT-ID)"
                            class="flex-1 px-4 py-2 rounded-md"></flux:input>
                        <flux:button icon="magnifying-glass" id="buscar-herramienta-btn">Buscar</flux:button>
                    </div>
                    <div id="herramienta-error" class="text-red-500 mt-2 hidden"></div>
                    <!-- Aquí puedes mostrar los datos de la herramienta encontrada -->
                    <div id="herramienta-result" class="mt-4"></div>
                    <input type="hidden" name="herramienta_id" id="herramienta_id" value="">
                    <div>
                        <flux:input type="date" name="fecha_captura" class="w-full px-3 py-2 rounded"
                            label="Fecha del Resguardo" value="{{ old('fecha_captura', date('Y-m-d')) }}" required>
                        </flux:input>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
            <div class="border rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold text-left mb-4">Firmas</h2>
                <div class="flex items-center justify-between gap-8">
                    <!-- Firma de "Entregado Por" -->
                    <div class="w-1/2 text-left flex flex-col">
                        <h2 class="font-semibold mb-2">Entregado Por</h2>
                        <canvas id="firmaEntregado" class="border w-full h-32 bg-white"></canvas>
                        <div class="flex justify-end gap-4 mt-2">
                            <flux:button type="button" onclick="guardarFirma('firmaEntregado', 'Entregado Por')">Guardar</flux:button>
                            <flux:button type="button" icon="trash" variant="danger" onclick="borrarFirma('firmaEntregado')">Borrar</flux:button>
                        </div>
                        <input type="hidden" name="firma_entregado_base64" id="firmaEntregadoInput">
                    </div>

                    <!-- Firma de "Recibido Por" -->
                    <div class="w-1/2 text-left flex flex-col">
                        <h2 class="font-semibold mb-2">Recibido Por</h2>
                        <canvas id="firmaRecibido" class="border w-full h-32 bg-white"></canvas>
                        <div class="flex justify-end gap-4 mt-2">
                            <flux:button type="button" onclick="guardarFirma('firmaRecibido', 'Recibido Por')">Guardar</flux:button>
                            <flux:button type="button" icon="trash" variant="danger" onclick="borrarFirma('firmaRecibido')">Borrar</flux:button>
                        </div>
                        <input type="hidden" name="firma_recibido_base64" id="firmaRecibidoInput">
                    </div>
                </div>
            </div>

    </div>
    <div class="mb-6">
        <flux:textarea label="Comentarios" is="textarea" name="comentarios" rows="3" class="w-full px-3 py-2 rounded">
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
        // Initialize signature pads
        initSignaturePad('firmaEntregado');
        initSignaturePad('firmaRecibido');

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

            fetch(`/herramientas/buscar?filtro=${encodeURIComponent(filtro)}&valor=${encodeURIComponent(valor)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    resultDiv.innerHTML = `
                        <div class="p-4 border rounded">
                            <strong>ID:</strong> ${data.id}<br>
                            <strong>Modelo:</strong> ${data.modelo}<br>
                            <strong>Número de Serie:</strong> ${data.num_serie}<br>
                            <strong>Artículo:</strong> ${data.articulo}<br>
                            <strong>Costo:</strong> ${data.costo ? '$' + Number(data.costo).toFixed(2) : 'N/A'}<br>
                        </div>
                    `;
                    document.getElementById('herramienta_id').value = data.id;
                })
                .catch(error => {
                    errorDiv.textContent = error.message;
                    errorDiv.classList.remove('hidden');
                });
        });
    });

    // Signature Pad functionality
    function initSignaturePad(canvasId) {
        const canvas = document.getElementById(canvasId);
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;
        
        // Set canvas size
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
        
        // Set background to white
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Set drawing style
        ctx.strokeStyle = '#000000';
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        
        // Drawing functions
        function startDrawing(e) {
            isDrawing = true;
            [lastX, lastY] = [e.offsetX, e.offsetY];
        }
        
        function draw(e) {
            if (!isDrawing) return;
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
            [lastX, lastY] = [e.offsetX, e.offsetY];
            
            // Update the hidden input
            updateSignatureInput(canvasId);
        }
        
        function stopDrawing() {
            isDrawing = false;
        }
        
        // Event listeners
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);
        
        // Touch support
        canvas.addEventListener('touchstart', (e) => {
            const touch = e.touches[0];
            const mouseEvent = new MouseEvent('mousedown', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        });
        
        canvas.addEventListener('touchmove', (e) => {
            const touch = e.touches[0];
            const mouseEvent = new MouseEvent('mousemove', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        });
        
        canvas.addEventListener('touchend', () => {
            const mouseEvent = new MouseEvent('mouseup');
            canvas.dispatchEvent(mouseEvent);
        });
    }
    
    function updateSignatureInput(canvasId) {
        const canvas = document.getElementById(canvasId);
        const input = document.getElementById(canvasId + 'Input');
        input.value = canvas.toDataURL();
    }
    
    function borrarFirma(canvasId) {
        const canvas = document.getElementById(canvasId);
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Clear the hidden input
        document.getElementById(canvasId + 'Input').value = '';
    }
    
    function guardarFirma(canvasId, firmadoPor) {
        const canvas = document.getElementById(canvasId);
        const firmaBase64 = canvas.toDataURL("image/png");
        
        // Update the hidden input for form submission
        document.getElementById(canvasId + 'Input').value = firmaBase64;
        
        // Optional: You can show a success message
        alert('Firma guardada correctamente');
        
        // If you want to send to server immediately:
        /*
        fetch('/firmas', {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                firma_base64: firmaBase64,
                firmado_por: firmadoPor
            })
        })
        .then(response => response.json())
        .then(data => alert(data.message))
        .catch(error => console.error('Error:', error));
        */
    }
</script>