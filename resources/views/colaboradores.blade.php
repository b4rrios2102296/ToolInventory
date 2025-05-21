<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Colaboradores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script>
        function filtrarColaboradores() {
            let input = document.getElementById("search").value.toLowerCase();
            let rows = document.querySelectorAll("tbody tr");

            rows.forEach(row => {
                let numColab = row.querySelector("td:first-child").textContent.toLowerCase();
                row.style.display = numColab.includes(input) ? "" : "none";
            });
        }

        function ocultarInicialmente() {
            let rows = document.querySelectorAll("tbody tr");
            rows.forEach(row => {
                row.style.display = "none"; // Oculta todas las filas al inicio
            });
        }

        window.onload = ocultarInicialmente; // Ejecuta la función al cargar la página
    </script>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Lista de Colaboradores</h1>

        <!-- Filtro de búsqueda con botón -->
        <div class="flex space-x-2 mb-4">
            <input type="text" id="search" placeholder="Ingrese número de colaborador..." 
                   class="w-full px-4 py-2 border rounded-md">
            <button onclick="filtrarColaboradores()" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-md">Buscar</button>
        </div>

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
</body>
</html>
