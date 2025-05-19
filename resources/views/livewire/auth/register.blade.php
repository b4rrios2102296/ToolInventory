<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold mb-6 text-center">Registro de Usuario</h1>

    @if(session('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="register">
        <div class="mb-4">
            <label for="numero_colaborador" class="block text-gray-700 mb-2">N° Colaborador</label>
            <input wire:model="numero_colaborador" type="number" id="numero_colaborador" 
                   class="w-full px-3 py-2 border rounded-lg @error('numero_colaborador') border-red-500 @enderror">
            @error('numero_colaborador') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 mb-2">Nombre</label>
            <input wire:model="nombre" type="text" id="nombre" 
                   class="w-full px-3 py-2 border rounded-lg @error('nombre') border-red-500 @enderror">
            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="apellidos" class="block text-gray-700 mb-2">Apellidos</label>
            <input wire:model="apellidos" type="text" id="apellidos" 
                   class="w-full px-3 py-2 border rounded-lg @error('apellidos') border-red-500 @enderror">
            @error('apellidos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        <div class="mb-4">
            <label for="email" class="block text-gray-700 mb-2">Email</label>
            <input wire:model="email" type="email" id="email" 
                   class="w-full px-3 py-2 border rounded-lg @error('email') border-red-500 @enderror">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 mb-2">Contraseña</label>
            <input wire:model="password" type="password" id="password" 
                   class="w-full px-3 py-2 border rounded-lg @error('password') border-red-500 @enderror">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 mb-2">Confirmar Contraseña</label>
            <input wire:model="password_confirmation" type="password" id="password_confirmation" 
                   class="w-full px-3 py-2 border rounded-lg">
        </div>

        <button type="submit" 
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">
            Registrar
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-blue-500 hover:underline">¿Ya tienes cuenta? Inicia sesión</a>
    </div>
</div>
