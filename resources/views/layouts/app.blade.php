<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    @fluxAppearance
    @livewireStyles
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <!-- SIDEBAR -->
    <flux:sidebar sticky class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="ToolInventory" class="px-2 dark:hidden" />
        <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="ToolInventory" class="px-2 hidden dark:flex" />

        <flux:input as="button" variant="filled" placeholder="Buscar..." icon="magnifying-glass" />
    
        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="#" current>Dashboard</flux:navlist.item>
            <flux:navlist.item href="{{ route('resguardos.create') }}">Resguardos</flux:navlist.item>
            <flux:navlist.group  heading="Inventario">
            <flux:navlist.item href="{{ route('herramientas.create') }}">Herramientas</flux:navlist.item>
            <flux:navlist.item icon="calendar" href="#">Calendar</flux:navlist.item>
            </flux:navlist.group>
            <flux:navlist.group>
            <flux:navlist.item href="#">Android app</flux:navlist.item>
            <flux:navlist.item href="#">Brand guidelines</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>
        <flux:spacer />

        <!-- Dynamic User Info in Sidebar -->
        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog-6-tooth" href="#">Configuración</flux:navlist.item>
        </flux:navlist>

        <flux:dropdown position="top" allign="start" class="max-lg:hidden">
            @if(Auth::check())
                <flux:profile avatar="https://fluxui.dev/img/demo/user.png" name="{{ Auth::user()->nombre }}" />
                <flux:menu>
                    <flux:menu.separator />
                    <flux:menu.item icon="arrow-right-start-on-rectangle">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Cerrar sesión</button>
                        </form>
                    </flux:menu.item>
                </flux:menu>
            @else
                <flux:menu.item icon="arrow-right-start-on-rectangle">
                    <a href="{{ route('login') }}">Iniciar sesión</a>
                </flux:menu.item>
            @endif
        </flux:dropdown>
    </flux:sidebar>

    <!-- HEADER -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
    </flux:header>

    <!-- MAIN CONTENT -->
    <main class="py-6 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    @livewireScripts
    @fluxScripts
</body>
</html>
