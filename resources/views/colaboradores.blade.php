<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Colaboradores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script>
        function buscarColaborador() {
            let input = document.getElementById("search").value.trim();
            let errorMessage = document.getElementById("error-message");
            let formResguardo = document.getElementById("form-resguardo");
            let tablaColaboradores = document.getElementById("tabla-colaboradores");

            // Ocultar elementos inicialmente
            errorMessage.style.display = "none";
            formResguardo.style.display = "none";
            tablaColaboradores.style.display = "none";

            // Hacer la petición AJAX al servidor
            fetch(`/buscar-colaborador?clave=${input}`)
                .then(response => response.json())
                .then(data => {
                    if(data.error) {
                        errorMessage.style.display = "block";
                        errorMessage.textContent = data.error;
                    } else {
                        // Llenar el formulario con los datos
                        document.getElementById("claveColab").value = data.claveColab;
                        document.getElementById("nombreCompleto").value = data.nombreCompleto;
                        document.getElementById("puesto").value = data.Puesto;
                        document.getElementById("area").value = data.area_limpia;
                        document.getElementById("sucursal").value = data.sucursal_limpia;
                        
                        // Mostrar el formulario
                        formResguardo.style.display = "block";
                    }
                })
                .catch(error => {
                    errorMessage.style.display = "block";
                    errorMessage.textContent = "Error al buscar el colaborador";
                });
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Sistema de Resguardos</h1>

        <!-- Buscador -->
        <div class="flex space-x-2 mb-4">
            <input type="text" id="search" placeholder="Ingrese número de colaborador..." 
                   class="w-full px-4 py-2 border rounded-md">
            <button onclick="buscarColaborador()" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-md">Buscar</button>
        </div>

        <!-- Mensaje de error -->
        <div id="error-message" class="text-red-500 font-semibold mb-4 hidden"></div>

        <!-- Formulario de Resguardo (oculto inicialmente) -->
        <div id="form-resguardo" class="bg-white shadow-md rounded-lg p-6 mb-8 hidden">
            <h2 class="text-xl font-semibold mb-4">Datos del Colaborador</h2>
            <form action="/guardar-resguardo" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700">Número de Colaborador</label>
                        <input type="text" id="claveColab" name="claveColab" 
                               class="w-full px-3 py-2 border rounded" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre Completo</label>
                        <input type="text" id="nombreCompleto" name="nombreCompleto" 
                               class="w-full px-3 py-2 border rounded" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Puesto</label>
                        <input type="text" id="puesto" name="puesto" 
                               class="w-full px-3 py-2 border rounded" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Área</label>
                        <input type="text" id="area" name="area" 
                               class="w-full px-3 py-2 border rounded" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Sucursal/Ambiente</label>
                        <input type="text" id="sucursal" name="sucursal" 
                               class="w-full px-3 py-2 border rounded" readonly>
                    </div>
                </div>

                <h2 class="text-xl font-semibold mt-6 mb-4">Datos del Resguardo</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700">Heramienta</label>
                        <select name="tipo_equipo" class="w-full px-3 py-2 border rounded" required>
                            <option value="">Seleccione...</option>
                            <option value="">Laptop</option>
                            <option value="Desktop">Desktop</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Teléfono">Teléfono</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Marca</label>
                        <input type="text" name="marca" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Modelo</label>
                        <input type="text" name="modelo" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Número de Serie</label>
                        <input type="text" name="numero_serie" class="w-full px-3 py-2 border rounded" required>
                    </div>
                </div>
                <label class="block text-gray-700">Estatus</label>
                        <select name="estatus" class="w-full px-3 py-2 border rounded" required>
                            <option value="">Seleccione...</option>
                            <option value="">Completo</option>
                            <option value="Desktop">En proceso</option>
                            <option value="Tablet">Pendiente</option>
                        </select>

                <div class="mb-4">
                    <label class="block text-gray-700">Fecha de Asignación</label>
                    <input type="date" name="fecha_asignacion" class="w-full px-3 py-2 border rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Observaciones</label>
                    <textarea name="observaciones" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">Guardar Resguardo</button>
                </div>
            </form>
        </div>

        <!-- Tabla de colaboradores (oculta inicialmente) -->
        <div id="tabla-colaboradores" class="hidden">
            <table class="table-auto w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">Num Colaborador</th>
                        <th class="px-4 py-2 border">Nombre Completo</th>
                        <th class="px-4 py-2 border">Puesto</th>
                        <th class="px-4 py-2 border">Area</th>
                        <th class="px-4 py-2 border">Ambiente</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($colaboradores as $colaborador)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border">{{ $colaborador->claveColab }}</td>
                        <td class="px-4 py-2 border">{{ $colaborador->nombreCompleto }}</td>
                        <td class="px-4 py-2 border">{{ $colaborador->Puesto }}</td>
                        <td class="px-4 py-2 border">{{ $colaborador->area_limpia }}</td>
                        <td class="px-4 py-2 border">{{ $colaborador->sucursal_limpia }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>