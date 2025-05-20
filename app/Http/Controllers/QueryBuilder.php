<?php
use Illuminate\Support\Facades\DB;

$datos = DB::connection('toolinventory')->table('nombre_tabla')->get();


?>