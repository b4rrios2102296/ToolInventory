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
            'estatus' => 'required|string|max:50',
            'articulo' => 'required|string|max:45',
            'unidad' => 'required|string|max:45',
            'modelo' => 'required|string|max:100',
            'num_serie' => 'required|string|max:100',
            'observaciones' => 'nullable|string|max:191',
            'costo' => 'required|numeric|min:0|max:100000',

        ]);

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

}