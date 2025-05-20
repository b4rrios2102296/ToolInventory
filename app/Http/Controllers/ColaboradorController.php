<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    public function index()
    {
        $colaboradores = DB::connection('colaboradores')->table('trabajador')->get();
        return view('colaboradores', compact('colaboradores'));
    }
}
