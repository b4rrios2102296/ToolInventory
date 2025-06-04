<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\HerramientasExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;



class HerramientaController extends Controller
{
    public function index()
    {
        $herramientas = DB::connection('toolinventory')->table('herramientas')->get();
        return view('herramientas.index', compact('herramientas'));
    }
    public function update(Request $request, $id)
    {
        $herramienta = DB::connection('toolinventory')->table('herramientas')->where('id', $id)->first();

        if (!$herramienta) {
            return redirect()->back()->withErrors(['herramienta_id' => 'La herramienta seleccionada no existe'])->withInput();
        }

        // If tool is in resguardo, don't allow status change
        $rules = [
            'articulo' => 'required|string|max:255',
            'unidad' => 'required|string|max:45',
            'modelo' => 'required|string|max:100',
            'num_serie' => 'required|string|max:100',
            'observaciones' => 'nullable|string|max:191',
            'costo' => 'required|numeric|min:0|max:100000',
        ];

        if ($herramienta->estatus != 'Resguardo') {
            $rules['estatus'] = 'nullable|string|in:Disponible,Baja';
        }

        $validated = $request->validate($rules);

        // Don't update status if tool is in resguardo
        $updateData = [
            'articulo' => $validated['articulo'],
            'unidad' => $validated['unidad'],
            'modelo' => $validated['modelo'],
            'num_serie' => $validated['num_serie'],
            'observaciones' => $validated['observaciones'] ?? null,
            'costo' => isset($validated['costo']) ? (float) $validated['costo'] : 0,
            'updated_at' => Carbon::now(),
        ];

        if ($herramienta->estatus != 'Resguardo') {
            $updateData['estatus'] = $validated['estatus'] ?? 'Disponible';
        }

        DB::connection('toolinventory')->table('herramientas')->where('id', $id)->update($updateData);

        return redirect()->route('herramientas.index')->with('success', 'Herramienta actualizada correctamente.');
    }
    public function edit($id)
    {
        $herramienta = DB::connection('toolinventory')->table('herramientas')->where('id', $id)->first();

        if (!$herramienta) {
            return redirect()->route('herramientas.index')->with('error', 'La herramienta no existe.');
        }

        // If the tool is in resguardo, find the corresponding resguardo
        $resguardo = null;
        if ($herramienta->estatus == 'Resguardo') {
            $resguardo = DB::connection('toolinventory')
                ->table('resguardos')
                ->where('detalles_resguardo', 'like', '%"id":"' . $herramienta->id . '"%')
                ->first();
        }

        return view('herramientas.edit', compact('herramienta', 'resguardo'));
    }

    public function baja(Request $request, $id)
    {
        // Validate incoming request to ensure "estatus" is either "Disponible" or "Baja"
        $request->validate([
            'estatus' => 'required|in:Disponible,Baja',
        ]);

        // Find the herramienta
        $herramienta = DB::connection('toolinventory')->table('herramientas')->where('id', $id)->first();

        if (!$herramienta) {
            return redirect()->route('herramientas.index')->with('error', 'La herramienta no existe.');
        }

        // Update the status instead of deleting the record
        DB::connection('toolinventory')->table('herramientas')
            ->where('id', $id)
            ->update([
                'estatus' => 'Baja',
                'updated_at' => now(),
            ]);

        return redirect()->route('herramientas.index')->with('success', 'Herramienta marcada como Baja.');
    }



    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'articulo' => 'required|string|max:255', // Añadir esta validación
            'estatus' => 'nullable|string|in:Disponible,Baja,Resguardo',
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

    public function show($id)
    {
        // Retrieve herramienta details
        $herramienta = DB::connection('toolinventory')->table('herramientas')->where('id', $id)->first();

        // Handle case where herramienta does not exist
        if (!$herramienta) {
            return redirect()->route('herramientas.index')->with('error', 'La herramienta no existe.');
        }

        // Return the show view with herramienta details
        return view('herramientas.show', compact('herramienta'));
    }


    public function buscarHerramienta(Request $request)
    {
        $filtro = $request->query('filtro', 'id'); // default to id
        $valor = $request->query('valor');

        $query = DB::connection('toolinventory')
            ->table('herramientas')
            ->where('estatus', 'Disponible');

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

        return response()->json([
            'id' => $herramienta->id,
            'modelo' => $herramienta->modelo,
            'num_serie' => $herramienta->num_serie,
            'articulo' => $herramienta->articulo,
            'costo' => $herramienta->costo // Ensure `costo` is included
        ], 200, [], JSON_UNESCAPED_UNICODE);

    }
    public function generarPDF()
    {
        $herramientas = DB::connection('toolinventory')
            ->table('herramientas')
            ->select(
                'id',
                'estatus',
                'articulo',
                'unidad',
                'modelo',
                'num_serie',
                'costo'
            )
            ->get();

        if ($herramientas->isEmpty()) {
            return redirect()->route('herramientas.index')->with('error', 'No hay herramientas disponibles.');
        }

        $pdf = PDF::loadView('herramientas.listapdf', compact('herramientas'));

        return $pdf->download('listado_herramientas.pdf');



    }
    public function generarExcel()
    {
        return Excel::download(new HerramientasExport, 'listado_herramientas.xlsx');
    }

}