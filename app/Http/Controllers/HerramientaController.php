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
            'cantidad'      => 'required|string|max:45',
            'articulo'      => 'required|string|max:45',
            'unidad'        => 'required|string|max:45',
            'modelo'        => 'required|string|max:100',
            'num_serie'     => 'required|string|max:100',
            'observaciones' => 'nullable|string|max:191',
        ]);

        // Insertar los valores en la base de datos
        DB::connection('toolinventory')->table('herramientas')->insert([
            // id es AI PK, no se incluye aquí para que lo genere la BD
            'cantidad'      => $validated['cantidad'],
            'articulo'      => $validated['articulo'],
            'unidad'        => $validated['unidad'],
            'modelo'        => $validated['modelo'],
            'num_serie'     => $validated['num_serie'],
            'observaciones' => $validated['observaciones'] ?? null,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
        

        // Redirigir con mensaje de éxito
        return redirect()->route('herramientas')->with('success', 'Herramienta creada exitosamente.');
    }

    public function create()
    {
        // Retorna la vista del formulario para crear una herramienta
        return view('herramientas.create');
    }
}