@extends('layouts.app')
@fluxAppearance

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center mb-4">
            <div class="ml-4 mt-2">
                @if(request()->has('selected'))
                    <flux:button icon="arrow-left" href="{{ route('admin.user-editor') }}">
                        Volver
                    </flux:button>
                @endif
            </div>
            <h1 class="text-2xl font-bold flex-1 text-center">Editor de Usuarios</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filtro de búsqueda -->
        <div class="mb-6">
            <form action="{{ route('admin.user-editor') }}" method="GET">
                <div class="flex items-center">
                    <flux:input type="search" name="search" placeholder="Buscar usuarios..." value="{{ request('search') }}"
                        class="flex-1" icon="magnifying-glass" />
                    <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Buscar
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.user-editor') }}"
                            class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Lista de usuarios -->
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Lista de Usuarios</h2>
                <ul class="divide-y divide-gray-200">
                    @forelse($users as $u)
                        <li
                            class="py-4 px-2 hover:bg-gray-50 cursor-pointer {{ request('selected') == $u->id ? 'bg-blue-50' : '' }}">
                            <a href="?selected={{ $u->id }}">
                                <p class="text-sm font-medium text-gray-900">{{ $u->nombre }} {{ $u->apellidos }}</p>
                                <p class="text-xs text-gray-400">Rol: {{ $u->role->nombre ?? 'Sin rol' }}</p>
                            </a>
                        </li>
                    @empty
                        <li class="py-4 px-2 text-center text-gray-500">
                            No se encontraron usuarios
                        </li>
                    @endforelse
                </ul>

                <!-- Paginación -->
                @if($users->hasPages())
                    <div class="mt-4">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

            <!-- Editor de usuario -->
            @if(request()->has('selected') && $selectedUser = \App\Models\Usuario::find(request('selected')))
                <div class="bg-white rounded shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Editar Usuario</h2>
                    <form method="POST" action="{{ route('admin.user-update', ['usuario' => $selectedUser->id]) }}"
                        class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <flux:label for="numero_colaborador">Número de Colaborador</flux:label>
                            <flux:input id="numero_colaborador" name="numero_colaborador" type="number"
                                value="{{ $selectedUser->numero_colaborador }}" />
                        </div>

                        <div>
                            <flux:label for="nombre">Nombre</flux:label>
                            <flux:input id="nombre" name="nombre" value="{{ $selectedUser->nombre }}" />
                        </div>

                        <div>
                            <flux:label for="apellidos">Apellidos</flux:label>
                            <flux:input id="apellidos" name="apellidos" value="{{ $selectedUser->apellidos }}" />
                        </div>

                        <div>
                            <flux:label for="nombre_usuario">Nombre de Usuario</flux:label>
                            <flux:input id="nombre_usuario" name="nombre_usuario" value="{{ $selectedUser->nombre_usuario }}" />
                        </div>

                        <div>
                            <flux:label for="password">Nueva Contraseña</flux:label>
                            <flux:input id="password" name="password" type="password" />
                        </div>

                        <div>
                            <flux:label for="password_confirmation">Confirmar Contraseña</flux:label>
                            <flux:input id="password_confirmation" name="password_confirmation" type="password" />
                        </div>

                        <div>
                            <flux:label for="rol_id">Rol</flux:label>
                            <flux:select name="rol_id" id="rol_id" class="w-full">
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ $selectedUser->rol_id == $rol->id ? 'selected' : '' }}>
                                        {{ $rol->nombre }}
                                    </option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="flex justify-end gap-4">
                            @if($selectedUser->id !== auth()->id())
                                <flux:modal.trigger name="eliminar-usuario-{{ $selectedUser->id }}">
                                    <flux:button icon="trash" variant="danger">
                                        Eliminar
                                    </flux:button>
                                </flux:modal.trigger>

                            @endif
                            <flux:button icon="document-check" type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Actualizar Usuario
                            </flux:button>
                        </div>
                    </form>

                    <!-- Modal para eliminar usuario -->
                    <flux:modal name="eliminar-usuario-{{ $selectedUser->id }}" class="md:w-96">
                        <div class="space-y-6">
                            <flux:heading size="lg">Eliminar Usuario</flux:heading>
                            <flux:text class="mt-2">
                                ¿Estás seguro de que deseas eliminar a {{ $selectedUser->nombre }}? Esta acción no se puede
                                deshacer.
                            </flux:text>

                            <form action="{{ route('admin.user-delete', $selectedUser->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end gap-4 mt-4">
                                    <flux:button href="{{ route('admin.user-editor') }}" variant="outline">
                                        Cancelar
                                    </flux:button>

                                    <flux:button type="submit" variant="danger"
                                        style="background-color:#dc2626 !important; color:white !important">
                                        Confirmar
                                    </flux:button>
                                </div>
                            </form>
                        </div>
                    </flux:modal>


                </div>
            @endif
        </div>
    </div>
@endsection