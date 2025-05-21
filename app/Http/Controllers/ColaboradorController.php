<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
public function index()
{
    $colaboradores = DB::connection('sqlsrv')
        ->table('colaborador')
        ->orderBy('claveColab', 'asc') 
        ->where('estado' ,'=','1')
        ->get();
    
    return view('colaboradores', compact('colaboradores'));
}
}
