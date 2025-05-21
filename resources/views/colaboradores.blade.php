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
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? "" : "none";
            });
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Lista de Colaboradores</h1>

        <!-- Filtro de búsqueda -->
        <input type="text" id="search" onkeyup="filtrarColaboradores()" placeholder="Buscar colaborador..." 
               class="w-full px-4 py-2 border rounded-md mb-4">

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
