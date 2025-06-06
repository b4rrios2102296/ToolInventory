<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Exports\HerramientasExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class HerramientaController extends Controller
{
    public function index()
    {
        $search = request('search');

        $query = DB::connection('toolinventory')
            ->table('herramientas')
            ->select('herramientas.*');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('herramientas.id', 'like', "%{$search}%")
                    ->orWhere('herramientas.estatus', 'like', "%{$search}%")
                    ->orWhere('herramientas.articulo', 'like', "%{$search}%")
                    ->orWhere('herramientas.unidad', 'like', "%{$search}%")
                    ->orWhere('herramientas.modelo', 'like', "%{$search}%")
                    ->orWhere('herramientas.num_serie', 'like', "%{$search}%")
                    ->orWhere('herramientas.costo', 'like', "%{$search}%")
                    ->orWhere('herramientas.observaciones', 'like', "%{$search}%");
            });
        }


    $herramientas = $query->orderByRaw("CAST(SUBSTRING_INDEX(herramientas.id, '-', -1) AS UNSIGNED) DESC")
                         ->paginate(10);

    if (request()->ajax()) {
        return response()->json([
            'html' => view('herramientas.index', compact('herramientas', 'search'))->render()
        ]);
    }
        return view('herramientas.index', compact('herramientas', 'search'));
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
        $request->validate([
            'estatus' => 'required|in:Disponible,Baja',
            'observaciones' => 'required|string',
        ]);

        try {
            DB::connection('toolinventory')->transaction(function () use ($request, $id) {
                DB::connection('toolinventory')->table('herramientas')
                    ->where('id', $id)
                    ->update([
                        'estatus' => 'Baja',
                        'observaciones' => $request->observaciones,
                        'updated_at' => now(),
                    ]);
            });

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'observaciones' => $request->observaciones, // Corregido
                ]);
            }

            return redirect()->route('herramientas.index')
                ->with('success', 'Herramienta marcada como Baja con observaciones.');

        } catch (\Exception $e) {
            Log::error('Error dando de baja herramienta: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error al dar de baja la herramienta'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Ocurrió un error al dar de baja la herramienta');
        }
    }
    public function destroy($id)
    {
        try {
            DB::connection('toolinventory')->transaction(function () use ($id) {
                $herramienta = DB::connection('toolinventory')
                    ->table('herramientas')
                    ->where('id', $id)
                    ->first();

                if (!$herramienta) {
                    throw new \Exception('Herramienta no encontrada.');
                }

                if (!auth()->user()->hasPermission('user_audit')) {
                    throw new \Exception('No tienes permisos para eliminar esta herramienta.');
                }

                DB::connection('toolinventory')
                    ->table('herramientas')
                    ->where('id', $id)
                    ->delete();
            });

            return redirect()->route('herramientas.index')
                ->with('success', 'Herramienta eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error eliminando herramienta: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ocurrió un error al eliminar la herramienta.');
        }
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

        // Retrieve related resguardo details
        $resguardo = DB::connection('toolinventory')
            ->table('resguardos')
            ->where('detalles_resguardo', 'like', '%"id":"' . $herramienta->id . '"%')
            ->first();

        // Return the show view with herramienta and resguardo details
        return view('herramientas.show', compact('herramienta', 'resguardo'));
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
            ->orderByRaw("CAST(SUBSTRING_INDEX(herramientas.id, '-', -1) AS UNSIGNED) DESC")
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