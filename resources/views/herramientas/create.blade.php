{{-- filepath: resources/views/herramientas/create.blade.php --}}
@extends('layouts.app')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-4">
        <div class="ml-4 mt-2">
            <flux:button icon="arrow-left" href="{{ route('herramientas.index') }}"></flux:button>
        </div>
        <h1 class="text-2xl font-bold flex-1 text-center">Registro de Herramientas</h1>
    </div>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('herramientas.store') }}" method="POST" class="rounded shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-gray-700 mb-1">Nombre/Artículo</label>
            <input type="text" name="articulo" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Modelo</label>
            <input type="text" name="modelo" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Unidad</label>
            <input type="text" name="unidad" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Número de Serie</label>
            <input type="text" name="num_serie" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Cantidad Disponible</label>
            <input type="text" name="cantidad" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Observaciones</label>
            <textarea name="observaciones" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
        </div>
        <div class="flex justify-end">
            <flux:button icon="document-plus" type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                Guardar Herramienta
            </flux:button>
        </div>
    </form>
</div>
</body>

</html>