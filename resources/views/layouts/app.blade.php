<!-- filepath: c:\xampp\htdocs\ToolInventory\resources\views\layouts\app.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Cache Control - Obligatorio para favicons -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>{{ config('app.name') }}</title>

    <!-- Favicon con versionado - PRIMER BLOQUE (ESENCIAL) -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v={{ time() }}" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v={{ time() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v={{ time() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v={{ time() }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}?v={{ time() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fuentes y estilos (conservando tu configuración original) -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.usefathom.com/script.js" data-site="KGGYBJLC" defer></script>


    <!--<link rel="preload" as="style" href="https://fluxui.dev/build/assets/app-Cu53mo6u.css" /> -->
    <!-- <link rel="stylesheet" href="https://fluxui.dev/build/assets/app-Cu53mo6u.css" data-navigate-track="reload" /> -->
    @fluxAppearance
</head>

<script>
    document.documentElement.classList.add('preload');
    window.addEventListener('DOMContentLoaded', () => {
        document.documentElement.classList.remove('preload');
    });

    // Interceptar formularios
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const transition = document.getElementById('page-transition');
            transition.classList.add('active');

            // Pequeño delay para que se vea la transición
            e.preventDefault();
            setTimeout(() => {
                this.submit();
            }, 300);
        });
    });
</script>


<body class="min-h-screen">

    <!-- Sidebar -->
    <flux:sidebar sticky stashable style="background-color: #F2F2F2" class="sidebar text-[#2E2E2E]">

        <!-- Toggle (mobile) -->
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <!-- Logo / Header -->
        <!-- Replace your current logo sections with this -->
        <div class="logo-container">
            <!-- Main logo -->
            <div class="main-logo-wrapper">
                <img src="{{ asset('Images/grand-velas-riviera-maya-mexico-logo.svg') }}" class="main-logo"
                    alt="GRAND VELAS" />
            </div>

            <!-- Secondary logo -->
            <div class="secondary-logo-wrapper">
                <img src="{{ asset('Images/Group 64.svg') }}" class="secondary-logo" alt="ToolInventory" />
            </div>
        </div>

        <!-- Navigation -->
        <flux:navlist class="main-navlist">
            <flux:navlist.item icon="cog" href="{{ route('dashboard') }}" class="navlist-bold">Dashboard
            </flux:navlist.item>
            <flux:navlist.item icon="square-3-stack-3d" href="{{ route('resguardos.index') }}" class="navlist-bold">
                Resguardos
            </flux:navlist.item>

            <flux:navlist.group expandable :expanded="false" heading="Inventario">
                <flux:navlist.item class="navlist-item" href="{{ route('herramientas.index') }}">Herramientas
                </flux:navlist.item>
            </flux:navlist.group>

            @if (Auth::user() && Auth::user()->hasPermission('user_audit'))
                <flux:navlist.group expandable :expanded="false" heading="Admin">
                    <flux:navlist.item class="navlist-item" href="{{ route('register') }}">Crear Usuario
                    </flux:navlist.item>
                    <flux:navlist.item class="navlist-item" href="{{ route('acciones') }}"> Auditoría de Usuarios
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
            <div style="display: flex; align-items: center; gap: 10px;">
                <flux:profile name="{{ Auth::user()->nombre ?? 'Usuario' }}"
                    class="dropdown-avatar profile-name navlist-item" />
            </div>
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
