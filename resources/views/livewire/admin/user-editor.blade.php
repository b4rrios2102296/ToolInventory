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
                            <li
                                class="py-4 hover:bg-gray-50 px-2 cursor-pointer {{ request()->has('selected') && request()->selected == $u->id ? 'bg-blue-50' : '' }}">
                                <a href="?selected={{ $u->id }}">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $u->name }}</p>
                                            <p class="text-xs text-gray-400">
                                                Roles: {{ $u->role?->nombre ?? 'Sin rol' }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- User Editor -->
                <div class="bg-white p-6 rounded-lg shadow">
                    @if(request()->has('selected') && $selectedUser = \App\Models\Usuario::find(request()->selected))
                        <h2 class="text-xl font-semibold mb-4">Editar Usuario</h2>
                        @php
                            $formAction = $selectedUser ? route('admin.user-update', ['usuario' => $selectedUser->id]) : '#';
                        @endphp

                        <form method="POST" action="{{ $formAction }}">
                            @csrf
                            @method('PUT')
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