<div class="max-w-md mx-auto p-8 bg-white rounded-lg shadow-md">
    <flux:text class="text-2xl font-bold mb-6 text-center" style="color: #2E2E2E; font-family: 'Athelas', serif;">
        Iniciar Sesión
    </flux:text>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login" class="space-y-4">
        <div>
            <flux:input 
                type="text" 
                wire:model="nombre_usuario" 
                label="Nombre de Usuario" 
                class="w-full"
                label-class="text-gray-700 mb-1"
                input-class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            @error('nombre_usuario')
            @enderror
        </div>

        <div>
            <flux:input 
                type="password" 
                wire:model="password" 
                label="Contraseña" 
                class="w-full"
                label-class="text-gray-700 mb-1"
                input-class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            @error('password')
            @enderror
        </div>

        <div class="pt-2">
            <flux:button 
                type="submit"
                class="w-full justify-center"
                style="background-color: #A4957D; font-family: 'Montserrat', sans-serif;"
                button-class="px-4 py-2 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors"
            >
                Ingresar
            </flux:button>
        </div>
    </form>
</div>