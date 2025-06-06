@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Historial de Acciones de Usuarios</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Resguardo ID</th>
                <th>Comentarios</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($acciones as $accion)
            <tr>
                <td>{{ $accion->nombre }} {{ $accion->apellidos }}</td>
                <td>{{ $accion->accion }}</td>
                <td>{{ $accion->resguardo_id }}</td>
                <td>{{ $accion->comentarios }}</td>
                <td>{{ \Carbon\Carbon::parse($accion->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $acciones->links() }}
</div>
@endsection
