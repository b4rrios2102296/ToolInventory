<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Dashboard</title>

    <!-- Fuentes y estilos -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    @fluxAppearance
    @livewireStyles
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <!-- HEADER con usuario a la derecha -->
    <flux:header class="sticky top-0 flex justify-between items-center p-4 bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
        <img src="{{ asset('Images/Simplification.png') }}" alt="Logo" class="w-32 mb-4" />
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <div class="flex items-center justify-end w-full">
            @if(Auth::check())
                <flux:dropdown position="bottom" allign="end">
                    <flux:profile icon:trailing="chevron-up-down" name="{{ Auth::user()->nombre }}" />
                    <flux:navmenu>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:navmenu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                                Cerrar sesión
                            </flux:navmenu.item>
                        </form>
                    </flux:navmenu>
                </flux:dropdown>
            @endif
        </div>
    </flux:header>

    <!-- SIDEBAR SOLO CON LISTA DE RUTAS -->
    <flux:sidebar sticky class="bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-l border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
        <flux:navlist variant="outline">
            <flux:navlist.item href="{{ route('dashboard') }}">Dashboard</flux:navlist.item>
            <flux:navlist.item href="{{ route('resguardos.create') }}">Resguardos</flux:navlist.item>
            <flux:navlist.item href="{{ route('herramientas.create') }}">Herramientas</flux:navlist.item>
            <flux:navlist.item href="{{ route('resguardos.index') }}">Lista de Resguardos</flux:navlist.item>
            <flux:navlist.item href="{{ route('herramientas.index') }}">Lista de Herramientas</flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>

    <main class="py-6 px-4 sm:px-6 lg:px-8">
    </main>

    @livewireScripts
    @fluxScripts
</body>

</html>