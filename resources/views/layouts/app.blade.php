<!-- filepath: c:\xampp\htdocs\ToolInventory\resources\views\layouts\app.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') }} - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fuentes y estilos -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.usefathom.com/script.js" data-site="KGGYBJLC" defer></script>
    <!--<link rel="preload" as="style" href="https://fluxui.dev/build/assets/app-Cu53mo6u.css" /> -->
    <!-- <link rel="stylesheet" href="https://fluxui.dev/build/assets/app-Cu53mo6u.css" data-navigate-track="reload" /> -->
    @fluxAppearance

</head>

<body class="min-h-screen">

    <!-- Sidebar -->
    <flux:sidebar sticky stashable style="background-color: #F2F2F2" class="sidebar text-[#2E2E2E]">

        <!-- Toggle (mobile) -->
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <!-- Logo / Header -->
        <div style="padding-bottom: 0; margin-top: -100px; margin-left: -120px;">
            <img src="{{ asset('Images/grand-velas-riviera-maya-mexico-logo.svg') }}"
                style="width: 100px; height: 205px;" class="mx-auto" />
        </div>

        <div class="flex flex-col items-center justify-center space-y-2 mb-8 mt-2 text-center">
            <div style="padding-bottom: -50px; margin-top: -150px;">
                <img src="{{ asset('Images/Group 64.svg') }}" style="width: 200px; margin-right: 50px;" />
            </div>
        </div>


        <!-- Navigation -->
        <flux:navlist style="padding-bottom: -50; margin-top: -90px;">
            <flux:navlist.item icon="cog" href="{{ route('dashboard') }}" class="navlist-bold">Dashboard
            </flux:navlist.item>
            <flux:navlist.item icon="square-3-stack-3d" href="{{ route('resguardos.index') }}" class="navlist-bold">
                Resguardos
            </flux:navlist.item>

            <flux:navlist.group expandable :expanded="false" heading="Inventario">
                <flux:navlist.item href="{{ route('herramientas.index') }}">Herramientas
                </flux:navlist.item>
            </flux:navlist.group>

            @if (Auth::user() && Auth::user()->hasPermission('user_audit'))
                <flux:navlist.group expandable :expanded="false" heading="Admin">
                    <flux:navlist.item href="{{ route('register') }}">Crear Usuario
                    </flux:navlist.item>
                    <flux:navlist.item href="{{ route('acciones') }}"> Auditoría de Usuarios
                    </flux:navlist.item>
                </flux:navlist.group>
            @endif

        </flux:navlist>

        <flux:spacer />

        <!-- Optional nav items -->
        <flux:navlist variant="outline">
            <!-- <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item> -->
            <!-- <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item> -->
        </flux:navlist>

        <!-- Profile dropdown -->
        <flux:dropdown position="top" allign="start" class="max-lg:hidden dropdown-text">
            <flux:profile avatar="" name="{{ Auth::user()->nombre ?? 'Usuario' }}" class="dropdown-avatar profile-name" />
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>{{ Auth::user()->nombre ?? 'Usuario' }}</flux:menu.radio>
                </flux:menu.radio.group>
                <flux:menu.separator />
                <flux:menu.item>
                    <flux:navmenu.item href="{{ route('logout') }}" icon="arrow-right-start-on-rectangle"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar sesión
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </flux:navmenu.item>
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Header for mobile -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        @if (Auth::check())
            <flux:dropdown position="top" allign="start">
                <flux:profile avatar="" name="{{ Auth::user()->nombre }}" />
                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.radio checked>{{ Auth::user()->nombre }}</flux:menu.radio>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <flux:menu.item href="{{ route('logout') }}" icon="arrow-right-start-on-rectangle"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar sesión
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        @endif
    </flux:header>

    <!-- Main Content -->
    <flux:main>
        @yield('content')
    </flux:main>
    @fluxScripts
    @livewireScripts
</body>

</html>