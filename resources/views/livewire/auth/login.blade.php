<div class="bg-[#FFF5E6] p-8 rounded-lg shadow-md w-full max-w-md">
    <flux:text class="text-2xl font-bold mb-6 text-center text-[#321F01]">Iniciar Sesión</flux:text>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login" class="text-[#321F01]">
        <div class="mb-4">
            <flux:input 
                type="text" 
                label="Nombre de usuario" 
                wire:model="nombre_usuario"
                class="w-full @error('nombre_usuario') border-red-500 @enderror placeholder:text-[#321F01] focus:ring-[#321F01] focus:border-[#321F01] text-[#321F01]"
            />
        </div>

        <div class="mb-4">
            <flux:input 
                type="password" 
                label="Contraseña" 
                wire:model="password"
                class="w-full @error('password') border-red-500 @enderror text-[#321F01] placeholder:text-[#321F01] focus:ring-[#321F01] focus:border-[#321F01]"
            />
        </div>

        <div class="mb-6 flex items-center">
        </div>

        <button type="submit"
            class="w-full bg-[#321F01] text-white py-2 px-4 rounded-lg hover:bg-brown transition">
            Ingresar 
        </button>
    </form>
    
</div>
