<div class="max-w-md mx-auto p-8 bg-white rounded-lg shadow-md">
    <div class="flex items-center mb-4">
        <flux:text class="text-2xl font-bold mb-6 text-center"
            style="color: #2E2E2E; font-family: 'Montserrat', sans-serif;">
            Registro de Usuario
        </flux:text>
    </div>




    <form wire:submit.prevent="register" class="space-y-5">
        <div>
            <flux:input type="number" wire:model="numero_colaborador" label="N° Colaborador" class="w-full"
                label-class="text-gray-700 mb-2 text-lg"
                input-class="px-5 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            @error('numero_colaborador')
            @enderror
        </div>

        <div>
            <flux:input type="text" wire:model="nombre" label="Nombre" class="w-full"
                label-class="text-gray-700 mb-2 text-lg"
                input-class="px-5 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            @error('nombre')
            @enderror
        </div>

        <div>
            <flux:input type="text" wire:model="apellidos" label="Apellidos" class="w-full"
                label-class="text-gray-700 mb-2 text-lg"
                input-class="px-5 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            @error('apellidos')
            @enderror
        </div>

        <div>
            <flux:input type="text" wire:model="nombre_usuario" label="Nombre de Usuario" class="w-full"
                label-class="text-gray-700 mb-2 text-lg"
                input-class="px-5 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            @error('nombre_usuario')
            @enderror
        </div>
        <div>
            <flux:select wire:model="rol_id" label="Rol" class="w-full" label-class="text-gray-700 mb-2 text-lg"
                select-class="px-5 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Selecciona un rol</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                @endforeach
            </flux:select>
            @error('rol_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <flux:input type="password" wire:model="password" label="Contraseña" class="w-full"
                label-class="text-gray-700 mb-2 text-lg"
                input-class="px-5 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            @error('password')
            @enderror
        </div>

        <div>
            <flux:input type="password" wire:model="password_confirmation" label="Confirmar Contraseña" class="w-full"
                label-class="text-gray-700 mb-2 text-lg"
                input-class="px-5 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="pt-3">
            <flux:button type="submit" class="w-full justify-center"
                style="background-color: #A4957D; font-family: 'Montserrat', sans-serif;"
                button-class="px-5 py-3 text-lg font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                Registrar
            </flux:button>
            <div class="mt-4 text-center">
                <a href="{{ route('admin.user-editor') }}" class="text-zinc-500 hover:underline">Regresar </a>
            </div>
        </div>
    </form>
</div>