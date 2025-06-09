<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Firma; // <-- IMPORTAR EL MODELO

class FirmaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'resguardo_id' => 'required|exists:resguardos,id',
            'firmado_por' => 'required|string',
            'firma_base64' => 'required',
        ]);

        Firma::create($request->all());

        return response()->json(['message' => 'Firma guardada exitosamente']);
    }
}
