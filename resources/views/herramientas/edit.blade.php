<!-- @extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center mb-4">
            <div class="ml-4 mt-2">
                <flux:button icon="arrow-left" href="{{ route('herramientas.index') }}">Volver </flux:button>
            </div>
            <h1 class="text-2xl font-bold flex-1 text-center">Editar Herramienta #{{ $herramienta->id }}</h1>
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

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('herramientas.update', $herramienta->id) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                Card: Datos de la Herramienta 
                    <div class="border rounded-lg shadow p-4 space-y-6">
                        <h2 class="text-lg font-semibold">Detalles de la Herramienta</h2>

                        <div>
                            @if($herramienta->estatus == 'Resguardo')
                                <div class="mb-4">
                                    <label class="block text-sm font-medium">Estatus</label>
                                    <div class="mt-1">
                                        @if($resguardo)
                                            <a href="{{ route('resguardos.show', $resguardo->folio) }}" class="hover:opacity-80">
                                                <flux:badge color="teal" class="inline-block">
                                                    Resguardo
                                                </flux:badge>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            @elseif($herramienta->estatus == 'Baja')
                                <flux:select label="Estatus de la Herramienta" name="estatus" class="w-full px-3 py-2 rounded">
                                    <option value="Baja" selected>Baja</option>
                                    <option value="Disponible">Disponible</option>
                                </flux:select>
                            @else
                                <flux:select label="Estatus de la Herramienta" name="estatus" class="w-full px-3 py-2 rounded">
                                    <option value="Disponible" selected>Disponible</option>
                                    <option value="Baja">Baja</option>
                                </flux:select>
                            @endif
                        </div>
                        <flux:input label="Artículo" name="articulo" :value="$herramienta->articulo" class="w-full" />
                        <flux:input label="Modelo" name="modelo" :value="$herramienta->modelo" class="w-full" />
                        <flux:select name="unidad" class="w-full px-3 py-2 rounded" label="Unidad" required>
                            <option value="Pieza" {{ old('unidad', $herramienta->unidad) == 'Pieza' ? 'selected' : '' }}>Pieza
                            </option>
                        </flux:select>
                        <flux:input label="Número de Serie" name="num_serie" :value="$herramienta->num_serie"
                            class="w-full" />
                        <flux:input label="Costo" name="costo" type="number" :value="$herramienta->costo" class="w-full" />
                    </div>

                
                    <div class="border rounded-lg shadow p-4 space-y-4">
                        <h2 class="text-lg font-semibold">Observaciones</h2>
                        <flux:textarea name="observaciones" rows="4" class="w-full">
                            {{ $herramienta->observaciones }}
                        </flux:textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <flux:button href="{{ route('herramientas.index') }}" icon="x-mark"
                        class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Cancelar
                    </flux:button>
                    <flux:button icon="document-plus" type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Guardar Cambios
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
@endsection-->