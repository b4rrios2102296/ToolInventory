@extends('layouts.app')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Editar Resguardo</h1>
    <form method="POST" action="{{ route('resguardos.update', $resguardo->folio) }}">
        @csrf
        @method('PUT')
        <!-- Ejemplo solo para estatus, agrega más campos según tu modelo -->
        <div class="mb-4">
            <label class="block">Estatus</label>
            <select name="estatus" class="w-full px-3 py-2 rounded">
                <option value="completo" {{ $resguardo->estatus == 'completo' ? 'selected' : '' }}>Completo</option>
                <option value="en proceso" {{ $resguardo->estatus == 'en proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="pendiente" {{ $resguardo->estatus == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            </select>
        </div>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Actualizar</button>
        <a href="{{ route('resguardos.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-md">Cancelar</a>
    </form>
</div>