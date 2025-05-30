<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HerramientaController extends Controller
{
    public function index()
    {
        $herramientas = DB::connection('toolinventory')->table('herramientas')->get();
        return view('herramientas.index', compact('herramientas'));
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'estatus' => 'nullable|string|in:Disponivle,Baja',
            'unidad' => 'required|string|max:45',
            'modelo' => 'required|string|max:100',
            'num_serie' => 'required|string|max:100',
            'observaciones' => 'nullable|string|max:191',
            'costo' => 'required|numeric|min:0|max:100000',

        ]);
        $validated['estatus'] = $validated['estatus'] ?? 'Disponible';

        // Insertar los valores en la base de datos
        DB::connection('toolinventory')->table('herramientas')->insert([
            // id es AI PK, no se incluye aquí para que lo genere la BD
            'estatus' => $validated['estatus'],
            'articulo' => $validated['articulo'],
            'unidad' => $validated['unidad'],
            'modelo' => $validated['modelo'],
            'num_serie' => $validated['num_serie'],
            'observaciones' => $validated['observaciones'] ?? null,
            'costo' => isset($validated['costo']) ? (float) $validated['costo'] : 0,
            'updated_at' => Carbon::now(),
        ]);


        // Redirigir con mensaje de éxito
        return redirect()->route('herramientas.index')->with('success', 'Herramienta creada exitosamente.');
    }

    public function create()
    {
        // Retorna la vista del formulario para crear una herramienta
        return view('herramientas.create');

    }

    public function buscarHerramienta(Request $request)
    {
        $filtro = $request->query('filtro', 'id'); // default to id
        $valor = $request->query('valor');

        $query = DB::connection('toolinventory')->table('herramientas');

        if ($filtro === 'id') {
            $query->where('id', $valor);
        } elseif ($filtro === 'modelo') {
            $query->where('modelo', 'like', "%$valor%");
        } elseif ($filtro === 'num_serie') {
            $query->where('num_serie', 'like', "%$valor%");
        } else {
            return response()->json(['error' => 'Filtro no válido']);
        }

        $herramienta = $query->first();

        if (!$herramienta) {
            return response()->json(['error' => 'No se encontró ninguna herramienta con ese filtro']);
        }

        return response()->json($herramienta);
    }

    public function edit($id)
{
    // Buscar la herramienta por ID
    $herramienta = DB::connection('toolinventory')->table('herramientas')->where('id', $id)->first();

    // Verificar si la herramienta existe
    if (!$herramienta) {
        return redirect()->route('herramientas.index')->with('error', 'Herramienta no encontrada.');
    }

    // Retornar la vista de edición con la herramienta encontrada
    return view('herramientas.edit', compact('herramienta'));
}

public function update(Request $request, $id)
{
    // Validar los datos recibidos
    $validated = $request->validate([
        'estatus' => 'nullable|string|in:Resguardo,Baja',
        'unidad' => 'required|string|max:45',
        'modelo' => 'required|string|max:100',
        'num_serie' => 'required|string|max:100',
        'observaciones' => 'nullable|string|max:191',
        'costo' => 'required|numeric|min:0|max:100000',
    ]);

    // Actualizar los valores en la base de datos
    $affected = DB::connection('toolinventory')->table('herramientas')
        ->where('id', $id)
        ->update([
            'estatus' => $validated['estatus'] ?? 'Resguardo',
            'unidad' => $validated['unidad'],
            'modelo' => $validated['modelo'],
            'num_serie' => $validated['num_serie'],
            'observaciones' => $validated['observaciones'] ?? null,
            'costo' => isset($validated['costo']) ? (float) $validated['costo'] : 0,
            'updated_at' => Carbon::now(),
        ]);

    // Validar si se actualizó correctamente
    if ($affected) {
        return redirect()->route('herramientas.index')->with('success', 'Herramienta actualizada exitosamente.');
    } else {
        return redirect()->route('herramientas.edit', $id)->with('error', 'No se pudo actualizar la herramienta.');
    }
}
public function show($id)
{
    // Obtener la herramienta por ID
    $herramienta = DB::connection('toolinventory')
        ->table('herramientas')
        ->where('id', $id)
        ->first();

    // Verificar si la herramienta existe
    if (!$herramienta) {
        return redirect()->route('herramientas.index')->with('error', 'Herramienta no encontrada.');
    }

    // Retornar la vista con la herramienta obtenida
    return view('herramientas.show', compact('herramienta'));
}

public function baja( $request, $id)
    {
        // ✅ Validate incoming request to ensure "estatus" is "Cancelado"
        $request->validate([
            'estatus' => 'required|in:Disponible,baja', // ✅ Allow both statuses
        ]);


        // ✅ Update the status instead of deleting the record
        DB::connection('toolinventory')->table('herramientas')
            ->where('id', $id)
            ->update(['estatus' => 'Baja', 'updated_at' => now()]);

        return redirect()->route('resguardos.index')->with('success', 'Resguardo marcado como Baja.');
    }


}