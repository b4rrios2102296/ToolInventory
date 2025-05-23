<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HerramientaController extends Controller
{
    public function index()
    {
        $herramientas = DB::connection('toolinventory')->table('herramientas')->get();
        return view('herramientas.index', compact('herramientas'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            // Add other fields and validation rules as needed
        ]);

        // Insert the new herramienta into the database
        DB::connection('toolinventory')->table('herramientas')->insert($validated);

        // Redirect back with success message
        return redirect()->route('herramientas')->with('success', 'Herramienta creada exitosamente.');
    }
    public function create()
    {
        // Retorna la vista del formulario para crear una herramienta
        return view('herramientas.create');
    }
}