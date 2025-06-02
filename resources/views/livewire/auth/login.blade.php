<div>
    <flux:text class="text-2xl font-bold mb-6 text-center">Iniciar Sesión</flux:text>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login">
        <div class="mb-4">
            <flux:input type="text" label="Nombre de usuario" wire:model="nombre_usuario" />
        </div>

        <div class="mb-4">
            <flux:input type="password" label="Contraseña" wire:model="password" />
        </div>

        <div class="mb-6 flex items-center">
        </div>

        <flux:button type="submit">
            Ingresar
        </flux:button>
    </form>

</div>