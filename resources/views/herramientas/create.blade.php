{{-- filepath: resources/views/herramientas/create.blade.php --}}
@extends('layouts.app')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-4">
        <div class="ml-4 mt-2">
            <flux:button icon="arrow-left" href="{{ route ('herramientas.index') }}">Volver</flux:button>
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
            <flux:label for="articulo">Nombre/Artículo</flux:label>
            <flux:input id="articulo" name="articulo" required />
        </div>
        <div>
            <flux:label for="modelo">Modelo</flux:label>
            <flux:input id="modelo" name="modelo" required />
        </div>
        <div>
            <flux:select name="unidad" label="Unidad" class="w-full px-3 py-2 rounded" required>
                <option value="Pieza" {{ old('unidad') == 'Pieza' ? 'selected' : '' }}>Pieza
                </option>
            </flux:select>
        </div>
        <div>
            <flux:label for="costo">Costo</flux:label>
            <flux:input id="costo" name="costo" type="number" min="0" step="0.01" required />
        </div>

        <div>
            <flux:label for="num_serie">Número de Serie</flux:label>
            <flux:input id="num_serie" name="num_serie" required />
        </div>

        <div>
            <flux:label for="observaciones">Observaciones</flux:label>
            <flux:textarea id="observaciones" name="observaciones" rows="3"></flux:textarea>
        </div>

        <div class="flex justify-end gap-4">
            <flux:button href="{{ url()->previous() }}" icon="x-mark"
                class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                Cancelar
            </flux:button>

            <flux:button icon="document-plus" type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                Guardar Herramienta
            </flux:button>
        </div>
    </form>
</div>