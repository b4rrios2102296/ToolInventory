@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if(auth()->user()->hasPermission('user_audit'))
        <h1 class="text-2xl font-bold mb-6">Editor de Usuarios</h1>

        @if(session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- User List -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Lista de Usuarios</h2>
                <ul class="divide-y divide-gray-200">
                    @foreach($users as $u)
                        <li class="py-4 hover:bg-gray-50 px-2 cursor-pointer {{ request('selected') == $u->id ? 'bg-blue-50' : '' }}">
                            <a href="?selected={{ $u->id }}">
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $u->nombre }} {{ $u->apellidos }}</p>
                                    <p class="text-xs text-gray-400">Rol: {{ $u->role->nombre ?? 'Sin rol' }}</p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- User Editor -->
            <div class="bg-white p-6 rounded-lg shadow">
                @if(request()->has('selected') && $selectedUser = \App\Models\Usuario::find(request('selected')))
                    <h2 class="text-xl font-semibold mb-4">Editar Usuario</h2>
                    <form method="POST" action="{{ route('admin.user-update', ['usuario' => $selectedUser->id]) }}">
                        @csrf
                        @method('PUT')

                        <!-- Campos del formulario -->
                        <div class="mb-4">
                            <label for="numero_colaborador" class="block font-medium">Número de Colaborador</label>
                            <input type="number" name="numero_colaborador" value="{{ $selectedUser->numero_colaborador }}" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label for="nombre" class="block font-medium">Nombre</label>
                            <input type="text" name="nombre" value="{{ $selectedUser->nombre }}" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label for="apellidos" class="block font-medium">Apellidos</label>
                            <input type="text" name="apellidos" value="{{ $selectedUser->apellidos }}" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label for="nombre_usuario" class="block font-medium">Nombre de Usuario</label>
                            <input type="text" name="nombre_usuario" value="{{ $selectedUser->nombre_usuario }}" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block font-medium">Nueva Contraseña</label>
                            <input type="password" name="password" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block font-medium">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-6">
                            <label for="rol_id" class="block font-medium">Rol</label>
                            <select name="rol_id" class="w-full border rounded px-3 py-2">
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ $selectedUser->rol_id == $rol->id ? 'selected' : '' }}>
                                        {{ $rol->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Actualizar Usuario
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @else
        <div class="bg-white p-6 rounded-lg shadow text-center py-8">
            <p class="text-red-500">No tienes acceso a esta vista.</p>
        </div>
    @endif
</div>
@endsection
