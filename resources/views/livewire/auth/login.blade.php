<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold mb-6 text-center">Iniciar Sesión</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login">
        <div class="mb-4">
            <label for="email" class="block text-gray-700 mb-2">Email</label>
            <input wire:model="email" type="text" id="email" 
                   class="w-full px-3 py-2 border rounded-lg @error('email') border-red-500 @enderror">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 mb-2">Contraseña</label>
            <input wire:model="password" type="password" id="password" 
                   class="w-full px-3 py-2 border rounded-lg @error('password') border-red-500 @enderror">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6 flex items-center">
            <input wire:model="remember" type="checkbox" id="remember" class="mr-2">
            <label for="remember">Recordar sesión</label>
        </div>

        <button type="submit" 
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">
            Ingresar
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('register') }}" class="text-blue-500 hover:underline">¿No tienes cuenta? Regístrate</a>
    </div>
</div>