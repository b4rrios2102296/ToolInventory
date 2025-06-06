<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResguardosExport;
class ResguardoController extends Controller
{
    public function store(Request $request)
    {
        Log::debug('Resguardo store method called', $request->all());

        $validated = $request->validate([
            'claveColab' => 'required|string',
            'herramienta_id' => 'required|string|exists:toolinventory.herramientas,id',
            'fecha_captura' => 'required|date',
            'comentarios' => 'nullable|string|max:500',
            'estatus' => 'nullable|string|in:Resguardo,Baja',
        ]);

        $validated['estatus'] = $validated['estatus'] ?? 'Resguardo';

        try {
            return DB::connection('toolinventory')->transaction(function () use ($validated) {
                // First, check if the tool exists and is available
                $herramienta = DB::connection('toolinventory')
                    ->table('herramientas')
                    ->where('id', $validated['herramienta_id'])
                    ->where('estatus', 'Disponible')
                    ->lockForUpdate() // Lock the row for update
                    ->first();

                if (!$herramienta) {
                    return redirect()->back()
                        ->withErrors(['herramienta_id' => 'La herramienta no está disponible o no existe'])
                        ->withInput();
                }

                // Check the collaborator
                $colaborador = DB::connection('sqlsrv')
                    ->table('colaborador')
                    ->where('claveColab', $validated['claveColab'])
                    ->where('estado', '1')
                    ->first();

                if (!$colaborador) {
                    return redirect()->back()
                        ->withErrors(['claveColab' => 'El colaborador no existe en la base de datos externa.'])
                        ->withInput();
                }

                $usuario = DB::connection('toolinventory')
                    ->table('usuarios')
                    ->where('id', auth()->id())
                    ->firstOrFail();

                $folio = $this->generarFolio();

                $detalles_resguardo = json_encode([
                    'id' => $herramienta->id,
                    'articulo' => $herramienta->articulo,
                    'modelo' => $herramienta->modelo,
                    'num_serie' => $herramienta->num_serie,
                    'unidad' => $herramienta->unidad,
                    'costo' => $herramienta->costo ?? 0,
                ]);

                // Create the resguardo
                DB::connection('toolinventory')->table('resguardos')->insert([
                    'folio' => $folio,
                    'estatus' => $validated['estatus'],
                    'colaborador_num' => $colaborador->claveColab,
                    'aperturo_users_id' => $usuario->id,
                    'asigno_users_id' => $usuario->id,
                    'fecha_captura' => Carbon::parse($validated['fecha_captura']),
                    'comentarios' => $validated['comentarios'],
                    'detalles_resguardo' => $detalles_resguardo,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update the tool status to "Resguardo"
                DB::connection('toolinventory')
                    ->table('herramientas')
                    ->where('id', $validated['herramienta_id'])
                    ->update(['estatus' => 'Resguardo', 'updated_at' => now()]);

                return redirect()->route('resguardos.index')
                    ->with('success', "Resguardo $folio creado exitosamente");
            });
        } catch (\Exception $e) {
            Log::error('Error creating resguardo: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ocurrió un error al crear el resguardo')
                ->withInput();
        }
    }


    protected function generarFolio()
    {
        $ultimo = DB::connection('toolinventory')
            ->table('resguardos')
            ->orderBy('folio', 'desc')
            ->first();

        return $ultimo ? intval($ultimo->folio) + 1 : 1;
    }

    public function index()
    {
        $search = request('search');

        $query = DB::connection('toolinventory')
            ->table('resguardos')
            ->leftJoin('usuarios as aperturo', 'resguardos.aperturo_users_id', '=', 'aperturo.id')
            ->select(
                'resguardos.*',
                'aperturo.nombre as aperturo_nombre',
                'aperturo.apellidos as aperturo_apellidos'
            );

        if ($search) {
            // Buscar en colaboradores primero
            $colaboradoresIds = DB::connection('sqlsrv')
                ->table('colaborador')
                ->where('nombreCompleto', 'like', "%{$search}%")
                ->orWhere('claveColab', 'like', "%{$search}%")
                ->pluck('claveColab')
                ->toArray();

            $query->where(function ($q) use ($search, $colaboradoresIds) {
                $q->where('resguardos.folio', 'like', "%{$search}%")
                    ->orWhere('resguardos.colaborador_num', 'like', "%{$search}%")
                    ->orWhere('aperturo.nombre', 'like', "%{$search}%")
                    ->orWhere('aperturo.apellidos', 'like', "%{$search}%")
                    ->orWhere('resguardos.estatus', 'like', "%{$search}%")
                    ->orWhere('resguardos.detalles_resguardo', 'like', "%{$search}%")
                    ->orWhere('resguardos.fecha_captura', 'like', "%{$search}%")
                    ->orWhereIn('resguardos.colaborador_num', $colaboradoresIds);
            });
        }

        $resguardos = $query->orderBy('resguardos.folio', 'desc')->paginate(15);

        // Obtener nombres de colaboradores
        $colaborador_nums = $resguardos->pluck('colaborador_num')->unique()->filter();
        $colaboradores = DB::connection('sqlsrv')
            ->table('colaborador')
            ->whereIn('claveColab', $colaborador_nums)
            ->pluck('nombreCompleto', 'claveColab');

        $resguardos->transform(function ($resguardo) use ($colaboradores) {
            $resguardo->colaborador_nombre = $colaboradores[$resguardo->colaborador_num] ?? '';
            $resguardo->detalles_herramienta = json_decode($resguardo->detalles_resguardo, true) ?? [];
            return $resguardo;
        });

        return view('resguardos.index', compact('resguardos'));
    }

    public function create()
    {
        $herramientas = DB::connection('toolinventory')
            ->table('herramientas')
            ->where('estatus', 'Disponible')
            ->get();

        return view('resguardos.create', compact('herramientas'));
    }

    public function buscarColaborador(Request $request)
    {
        $colaborador = DB::connection('sqlsrv')
            ->table('colaborador')
            ->select(
                '*'
            )
            ->selectRaw("
                LTRIM(RTRIM(RIGHT(Area, LEN(Area) - CHARINDEX('-', Area)))) AS area_limpia,
                LTRIM(RTRIM(RIGHT(Sucursal, LEN(Sucursal) - CHARINDEX('-', Sucursal)))) AS sucursal_limpia
            ")
            ->where(function ($query) use ($request) {
                $query->where('claveColab', 'like', '%' . $request->clave . '%')
                    ->orWhere('nombreCompleto', 'like', '%' . $request->clave . '%');
            })
            ->where('estado', '1')
            ->first();

        return response()->json($colaborador ?? ['error' => 'No se encontró el colaborador']);
    }


    // public function edit($folio)
    // {
    //  $resguardo = DB::connection('toolinventory')
    //   ->table('resguardos')
    // ->where('folio', $folio)
    // ->first();

    // if (!$resguardo) {
    //  abort(404);
    // }

    // $detalles = json_decode($resguardo->detalles_resguardo, true) ?? [];

    // $herramienta = DB::connection('toolinventory')
    //  ->table('herramientas')
    // ->where('id', $detalles['id'] ?? null)
    // ->first();

    // Get collaborator name from SQL Server
    // $colaborador_nombre = DB::connection('sqlsrv')
    //  ->table('colaborador')
    // ->where('claveColab', $resguardo->colaborador_num)
    // >value('nombreCompleto');


    // return view('resguardos.edit', [
    //  'resguardo' => $resguardo,
    // 'herramienta' => $herramienta,
    // 'detalles' => $detalles,
    // 'colaborador_nombre' => $colaborador_nombre,
    // 'costo' => $herramienta->costo ?? 0
    // ]);
    // }


    // Update action


    public function update(Request $request, $folio)
    {
        $validated = $request->validate([
            'estatus' => 'required|string|in:Resguardo,Cancelado',
            'colaborador_num' => 'required|string',
            'herramienta_id' => 'required|string|exists:toolinventory.herramientas,id',
            'fecha_captura' => 'required|date',
            'comentarios' => 'nullable|string|max:500',
        ]);

        try {
            return DB::connection('toolinventory')->transaction(function () use ($validated, $folio, $request) {
                // 1. Get the current resguardo and its herramienta
                $currentResguardo = DB::connection('toolinventory')
                    ->table('resguardos')
                    ->where('folio', $folio)
                    ->first();

                if (!$currentResguardo) {
                    throw new \Exception('Resguardo no encontrado');
                }

                $currentDetalles = json_decode($currentResguardo->detalles_resguardo, true);
                $currentHerramientaId = $currentDetalles['id'] ?? null;

                // 2. Check if herramienta is being changed
                $isChangingHerramienta = ($currentHerramientaId != $validated['herramienta_id']);

                // 3. If changing herramienta:
                if ($isChangingHerramienta) {
                    // a. Verify new herramienta is available
                    $newHerramienta = DB::connection('toolinventory')
                        ->table('herramientas')
                        ->where('id', $validated['herramienta_id'])
                        ->where('estatus', 'Disponible')
                        ->lockForUpdate()
                        ->first();

                    if (!$newHerramienta) {
                        throw new \Exception('La nueva herramienta no está disponible');
                    }

                    // b. Release old herramienta (set to Disponible)
                    if ($currentHerramientaId) {
                        DB::connection('toolinventory')
                            ->table('herramientas')
                            ->where('id', $currentHerramientaId)
                            ->update([
                                'estatus' => 'Disponible',
                                'updated_at' => now()
                            ]);
                    }

                    // c. Reserve new herramienta (set to Resguardo)
                    DB::connection('toolinventory')
                        ->table('herramientas')
                        ->where('id', $validated['herramienta_id'])
                        ->update([
                            'estatus' => 'Resguardo',
                            'updated_at' => now()
                        ]);
                }

                // 4. Update the resguardo record
                $herramienta = DB::connection('toolinventory')
                    ->table('herramientas')
                    ->where('id', $validated['herramienta_id'])
                    ->first();

                $detalles_resguardo = json_encode([
                    'id' => $herramienta->id,
                    'articulo' => $herramienta->articulo,
                    'modelo' => $herramienta->modelo,
                    'num_serie' => $herramienta->num_serie,
                    'unidad' => $herramienta->unidad,
                    'costo' => $herramienta->costo ?? 0,
                ]);

                DB::connection('toolinventory')
                    ->table('resguardos')
                    ->where('folio', $folio)
                    ->update([
                        'estatus' => $validated['estatus'],
                        'colaborador_num' => $validated['colaborador_num'],
                        'fecha_captura' => Carbon::parse($validated['fecha_captura']),
                        'comentarios' => $validated['comentarios'],
                        'detalles_resguardo' => $detalles_resguardo,
                        'updated_at' => now(),
                    ]);

                return redirect()->route('resguardos.index')
                    ->with('success', 'Resguardo actualizado correctamente');
            });
        } catch (\Exception $e) {
            Log::error('Error updating resguardo: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al actualizar: ' . $e->getMessage())
                ->withInput();
        }
    }

    // cancel action
    public function cancel(Request $request, $folio)
    {
        $request->validate([
            'estatus' => 'required|in:Resguardo,Cancelado',
            'comentarios' => 'required|string', // Añadir validación para el campo comentarios
        ]);

        try {
            DB::connection('toolinventory')->transaction(function () use ($request, $folio) {
                // Get the resguardo to find the herramienta_id
                $resguardo = DB::connection('toolinventory')
                    ->table('resguardos')
                    ->where('folio', $folio)
                    ->first();

                if ($resguardo) {
                    $detalles = json_decode($resguardo->detalles_resguardo, true);
                    $herramienta_id = $detalles['id'] ?? null;

                    // Update the resguardo status and comments
                    DB::connection('toolinventory')
                        ->table('resguardos')
                        ->where('folio', $folio)
                        ->update([
                            'estatus' => 'Cancelado',
                            'comentarios' => $request->comentarios, // Guardar el comentario
                            'updated_at' => now()
                        ]);

                    // If there's a herramienta associated, set it back to Disponible
                    if ($herramienta_id) {
                        DB::connection('toolinventory')
                            ->table('herramientas')
                            ->where('id', $herramienta_id)
                            ->update(['estatus' => 'Disponible', 'updated_at' => now()]);
                    }
                }
            });

            return redirect()->route('resguardos.index')
                ->with('success', 'Resguardo marcado como Cancelado y herramienta liberada.');

        } catch (\Exception $e) {
            Log::error('Error canceling resguardo: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ocurrió un error al cancelar el resguardo');
        }
    }
    public function destroy(Request $request, $folio)
    {
        try {
            DB::connection('toolinventory')->transaction(function () use ($folio) {
                // Verificar si el resguardo existe
                $resguardo = DB::connection('toolinventory')
                    ->table('resguardos')
                    ->where('folio', $folio)
                    ->first();

                if (!$resguardo) {
                    throw new \Exception('Resguardo no encontrado.');
                }

                // Verificar permisos
                if (!auth()->user()->hasPermission('user_audit')) {
                    throw new \Exception('No tienes permisos para eliminar este resguardo.');
                }

                // Eliminar el resguardo
                DB::connection('toolinventory')
                    ->table('resguardos')
                    ->where('folio', $folio)
                    ->delete();
            });

            return redirect()->route('resguardos.index')
                ->with('success', 'Resguardo eliminado correctamente.');

        } catch (\Exception $e) {
            Log::error('Error eliminando resguardo: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ocurrió un error al eliminar el resguardo.');
        }
    }





    public function show($folio)
    {
        // Fetch the resguardo details along with "aperturo" user info
        $resguardo = DB::connection('toolinventory')
            ->table('resguardos')
            ->leftJoin('usuarios as aperturo', 'resguardos.aperturo_users_id', '=', 'aperturo.id')
            ->select(
                'resguardos.*',
                'aperturo.nombre as aperturo_nombre',
                'aperturo.apellidos as aperturo_apellidos'
            )
            ->where('folio', $folio)
            ->first();

        if (!$resguardo) {
            return redirect()->route('resguardos.index')->with('error', 'Resguardo no encontrado');
        }

        // Retrieve "Asignado a" name based on asigno_users_id in SQL Server
        $asignado_nombre = DB::connection('sqlsrv')
            ->table('colaborador')
            ->where('claveColab', $resguardo->colaborador_num) // Assuming asigno_users_id is actually colaborador_num
            ->pluck('nombreCompleto', 'claveColab');

        $resguardo->asignado_nombre = $asignado_nombre[$resguardo->colaborador_num] ?? 'No asignado';

        // Decode detalles_resguardo properly
        $detalles = json_decode($resguardo->detalles_resguardo, true) ?? [];
        $herramienta = DB::connection('toolinventory')->table('herramientas')->where('id', $detalles['id'] ?? null)->first();

        return view('resguardos.show', compact('resguardo', 'herramienta'));
    }

    public function viewPDF($folio)
    {
        // Fetch resguardo details
        $resguardo = DB::connection('toolinventory')
            ->table('resguardos')
            ->leftJoin('usuarios as aperturo', 'resguardos.aperturo_users_id', '=', 'aperturo.id')
            ->select(
                'resguardos.*',
                'aperturo.nombre as aperturo_nombre',
                'aperturo.apellidos as aperturo_apellidos'
            )
            ->where('folio', $folio)
            ->first();

        if (!$resguardo) {
            return redirect()->route('resguardos.index')->with('error', 'Resguardo no encontrado');
        }

        // Retrieve collaborator details
        $colaborador = DB::connection('sqlsrv')
            ->table('colaborador')
            ->select(
                'claveColab',
                'nombreCompleto',
                'Puesto',
                'Area',
                'Sucursal'
            )
            ->selectRaw("
            LTRIM(RTRIM(RIGHT(Area, LEN(Area) - CHARINDEX('-', Area)))) AS area_limpia,
            LTRIM(RTRIM(RIGHT(Sucursal, LEN(Sucursal) - CHARINDEX('-', Sucursal)))) AS sucursal_limpia
        ")
            ->where('claveColab', $resguardo->colaborador_num)
            ->where('estado', '1')
            ->first();

        // Herramienta
        $detalles = json_decode($resguardo->detalles_resguardo, true) ?? [];
        $herramienta = DB::connection('toolinventory')
            ->table('herramientas')
            ->where('id', $detalles['id'] ?? null)
            ->first();

        // Generar PDF
        $pdf = Pdf::loadView('resguardos.pdf', [
            'resguardo' => $resguardo,
            'herramienta' => $herramienta,
            'detalles' => $detalles,
            'colaborador' => $colaborador // Pass collaborator data to the view
        ]);

        return $pdf->stream("resguardo_{$folio}.pdf");
    }




    public function generarPDF()
    {
        // Fetch all resguardos from toolinventory
        $resguardos = DB::connection('toolinventory')
            ->table('resguardos')
            ->leftJoin('usuarios as aperturo', 'resguardos.aperturo_users_id', '=', 'aperturo.id')
            ->select(
                'resguardos.*',
                'aperturo.nombre as aperturo_nombre',
                'aperturo.apellidos as aperturo_apellidos'
            )
            ->get();

        if ($resguardos->isEmpty()) {
            return redirect()->route('resguardos.index')->with('error', 'No hay resguardos disponibles.');
        }

        // Fetch collaborator details
        $colaborador_nums = $resguardos->pluck('colaborador_num')->filter()->unique();
        $colaboradores = DB::connection('sqlsrv')
            ->table('colaborador')
            ->whereIn('claveColab', $colaborador_nums)
            ->pluck('nombreCompleto', 'claveColab');

        // Retrieve Herramienta details
        foreach ($resguardos as $resguardo) {
            $detalles = json_decode($resguardo->detalles_resguardo, true) ?? [];

            $herramienta = DB::connection('toolinventory')
                ->table('herramientas')
                ->where('id', $detalles['id'] ?? null)
                ->first();

            // Assign collaborator and herramienta details
            $resguardo->colaborador_nombre = $colaboradores[$resguardo->colaborador_num] ?? 'No disponible';
            $resguardo->herramienta_articulo = $herramienta->articulo ?? 'N/A';
            $resguardo->herramienta_modelo = $herramienta->modelo ?? 'N/A';
            $resguardo->herramienta_num_serie = $herramienta->num_serie ?? 'N/A';
            $resguardo->herramienta_costo = $herramienta->costo ?? 0;
        }

        // Generate PDF
        $pdf = PDF::loadView('resguardos.listapdf', compact('resguardos'));

        return $pdf->download("listado_resguardos.pdf");
    }




    public function collection()
    {
        // Fetch all resguardos from toolinventory
        $resguardos = DB::connection('toolinventory')
            ->table('resguardos')
            ->leftJoin('usuarios as aperturo', 'resguardos.aperturo_users_id', '=', 'aperturo.id')
            ->select(
                'resguardos.folio',
                'resguardos.estatus',
                'aperturo.nombre as aperturo_nombre',
                'aperturo.apellidos as aperturo_apellidos',
                'resguardos.fecha_captura',
                'resguardos.colaborador_num'
            )
            ->get();

        // Fetch collaborator details
        $colaborador_nums = $resguardos->pluck('colaborador_num')->filter()->unique();
        $colaboradores = DB::connection('sqlsrv')
            ->table('colaborador')
            ->whereIn('claveColab', $colaborador_nums)
            ->pluck('nombreCompleto', 'claveColab');

        foreach ($resguardos as $resguardo) {
            $detalles = json_decode($resguardo->detalles_resguardo, true) ?? [];

            $herramienta = DB::connection('toolinventory')
                ->table('herramientas')
                ->where('id', $detalles['id'] ?? null)
                ->first();

            // Assign collaborator and herramienta details
            $resguardo->colaborador_nombre = $colaboradores[$resguardo->colaborador_num] ?? 'No disponible';
            $resguardo->herramienta_articulo = $herramienta->articulo ?? 'N/A';
            $resguardo->herramienta_modelo = $herramienta->modelo ?? 'N/A';
            $resguardo->herramienta_num_serie = $herramienta->num_serie ?? 'N/A';
            $resguardo->herramienta_costo = $herramienta->costo ?? 0;
        }

        return $resguardos;
    }

    public function headings(): array
    {
        return [
            'Folio',
            'Estado',
            'Realizó Resguardo',
            'Asignado a',
            'Fecha de Resguardo',
            'Artículo',
            'Modelo',
            'Número de Serie',
            'Costo'
        ];

    }
    public function generarExcel()
    {
        return Excel::download(new ResguardosExport, 'listado_resguardos.xlsx');
    }

    public function changeStatus(Request $request, $folio)
    {
        try {
            DB::connection('toolinventory')
                ->table('resguardos')
                ->where('folio', $folio)
                ->update([
                    'estatus' => 'Resguardo', // Automatically sets status to Resguardo
                    'updated_at' => now(),
                ]);

            return back()->with('success', 'Estatus cambiado a Resguardo.');
        } catch (\Exception $e) {
            Log::error('Error al cambiar estatus: ' . $e->getMessage());
            return back()->with('error', 'Error al cambiar estatus.');
        }
    }

}



