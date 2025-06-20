@extends('layouts.app')
@fluxAppearance

@section('content')
    <div class="container mx-auto max-w-screen-xl px-4 py-4">

        {{-- Título --}}
        <div class="mb-2">
            <h1 class="text-2xl font-bold text-center">Editor de Usuarios</h1>
        </div>

        {{-- Separador --}}
        <flux:separator />
        <br>

        {{-- Controles: Volver, Crear Usuario, Búsqueda --}}
        <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
            <div class="flex items-center space-x-2">
                @if(request()->has('selected'))
                    <flux:button icon="arrow-left" href="{{ route('admin.user-editor') }}">
                        Volver
                    </flux:button>
                    <flux:separator vertical />
                @endif
                @if (request()->routeIs('admin.user-editor'))
                    <flux:button icon="user-plus" href="{{ route('register') }}">
                        Crear Usuario
                    </flux:button>
                @endif
            </div>

            <div class="w-full sm:w-auto mt-2 sm:mt-0">
                <form action="{{ route('admin.user-editor') }}" method="GET" class="flex items-center space-x-2">
                    <flux:input id="searchInput" type="search" name="search" placeholder="Buscar usuarios..."
                        value="{{ request('search') }}" class="w-64" icon="magnifying-glass" />
                </form>
            </div>
        </div>



    @if(session('success') || session('error'))
        <div id="toast-container">
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
        </div>

        <script>
            setTimeout(function () {
                const toast = document.getElementById('toast-container');
                if (toast) {
                    toast.style.transition = 'opacity 0.5s ease';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500); // elimina después de la animación
                }
            }, 3000);
        </script>
    @endif




        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Lista de Usuarios</h2>
                <ul class="divide-y divide-gray-200">
                    @forelse($users as $u)
                        <li
                            class="py-2 px-2 hover:bg-gray-50 cursor-pointer {{ request('selected') == $u->id ? 'bg-blue-50' : '' }}">
                            <a href="?selected={{ $u->id }}">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $u->nombre }} {{ $u->apellidos }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    Rol: {{ $u->role->nombre ?? 'Sin rol' }}
                                </p>

                            </a>
                        </li>
                    @empty
                        <li class="py-4 px-2 text-center text-gray-500">
                            No se encontraron usuarios
                        </li>
                    @endforelse
                </ul>
                @if($users->hasPages())
                    <div class="mt-4">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

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
                                <flux:tooltip content="Eliminar Usuario">
                                    <flux:modal.trigger name="eliminar-usuario-{{ $selectedUser->id }}">
                                        <flux:button icon="trash" variant="danger">
                                            Eliminar
                                        </flux:button>
                                    </flux:modal.trigger>
                                </flux:tooltip>

                            @endif
                            <flux:button icon="document-check" type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Actualizar Usuario
                            </flux:button>
                        </div>
                    </form>

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
                                    <flux:button type="submit" variant="danger" class="bg-red-600 text-white"
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            let searchTimer;

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    clearTimeout(searchTimer);

                    searchTimer = setTimeout(function () {
                        const searchValue = searchInput.value;

                        fetch(`{{ route('admin.user-editor') }}?search=${encodeURIComponent(searchValue)}`)
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');

                                const newList = doc.querySelector('ul.divide-y');
                                const pagination = doc.querySelector('.pagination');
                                const oldList = document.querySelector('ul.divide-y');

                                if (newList && oldList) {
                                    oldList.innerHTML = newList.innerHTML;
                                }

                                if (pagination && document.querySelector('.pagination')) {
                                    document.querySelector('.pagination').innerHTML = pagination.innerHTML;
                                }
                            });
                    }, 400);
                });
            }
        });
    </script>

@endsection