<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Colaboradores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Lista de Colaboradores</h1>
        <table class="table-auto w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Nombre</th>
                    <th class="px-4 py-2 border">Apellido Paterno</th>
                    <th class="px-4 py-2 border">Apellido Materno</th>
                    <th class="px-4 py-2 border">Num Colaborador</th>
                    <th class="px-4 py-2 border">Departamento</th>
                    <th class="px-4 py-2 border">Puesto</th>
                    <th class="px-4 py-2 border">Ambiente</th>
                </tr>
            </thead>
            <tbody>
                @foreach($colaboradores as $colaborador)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border">{{ $colaborador->Ident }}</td>
                    <td class="px-4 py-2 border">{{ $colaborador->nombre }}</td>
                    <td class="px-4 py-2 border">{{ $colaborador->paterno }}</td>
                    <td class="px-4 py-2 border">{{ $colaborador->materno }}</td>
                    <td class="px-4 py-2 border">{{ $colaborador->clv_trab }}</td>
                    <td class="px-4 py-2 border">{{ $colaborador->clvE_depto }}</td>
                    <td class="px-4 py-2 border">{{ $colaborador->clvE_puesto }}</td>
                    <td class="px-4 py-2 border">{{ $colaborador->clvE_sucursal }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
