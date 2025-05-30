<!-- filepath: c:\xampp\htdocs\ToolInventory\resources\views\layouts\app.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') }} - Dashboard</title>

    <!-- Fuentes y estilos -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="/faviconcircle16x16.png" type="image/png" sizes="16x16" />
    <link rel="icon" href="/faviconcircle32x32.png" type="image/png" sizes="32x32" />
    <link rel="apple-touch-icon" href="/apple-touch-icon-circle.png" sizes="180x180" />
    <meta name="algolia-site-verification" content="A39CBDEB76ED91E0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3" />
    <script src="https://cdn.usefathom.com/script.js" data-site="KGGYBJLC" defer></script>
    @livewireStyles
    <link rel="preload" as="style" href="https://fluxui.dev/build/assets/app-Cu53mo6u.css" />
    <link rel="stylesheet" href="https://fluxui.dev/build/assets/app-Cu53mo6u.css" data-navigate-track="reload" />

<script>
  document.addEventListener('DOMContentLoaded', function() {
      document.body.style.backgroundColor = '#FFF5E6';
      document.body.style.color = '#321F01';
      document.documentElement.style.backgroundColor = '#FFF5E6';
      document.documentElement.style.color = '#321F01';
    
  });
</script>
    <style>
        [wire\:loading],
        [wire\:loading.delay],
        [wire\:loading.inline-block],
        [wire\:loading.inline],
        [wire\:loading.block],
        [wire\:loading.flex],
        [wire\:loading.table],
        [wire\:loading.grid],
        [wire\:loading.inline-flex],
        [wire\:loading.delay.none],
        [wire\:loading.delay.shortest],
        [wire\:loading.delay.shorter],
        [wire\:loading.delay.short],
        [wire\:loading.delay.default],
        [wire\:loading.delay.long],
        [wire\:loading.delay.longer],
        [wire\:loading.delay.longest],
        [wire\:offline],
        [wire\:dirty]:not(textarea):not(input):not(select) {
            display: none;
        }
    </style>
</head>

<body class="min-h-screen bg-[#FFF5E6] text-[#321F01]">

    <!-- Sidebar -->
    <flux:sidebar sticky stashable style="background-color: #321F01 !important; color: #FFF5E6 !important;">

        <!-- Toggle (mobile) -->
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <!-- Logo / Header -->
        <div class="flex flex-col items-center justify-center space-y-2 mb-8 mt-2 text-center">
            <img src="{{ asset('Images/Simplification1.svg') }}" class="w-15 h-15 mx-auto" />
            <div class="flex items-center justify-center">
                <img src="{{ asset('Images/logoGrandVelas.svg') }}" alt="Grand Velas Logo" class="w-8 h-8 mr-2" />
                <div class="text-left">
                    <div class="font-bold text-xs" style="color: #FFF5E6;">Departamento de Sistemas</div>
                    <div class="text-xs" style="color: #FFF5E6;">Grand Velas Riviera Maya</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog" href="{{ route('dashboard') }} " class>Dashboard</flux:navlist.item>
            <flux:navlist.item icon="square-3-stack-3d" href="{{ route('resguardos.index') }}">Resguardos</flux:navlist.item>

            <flux:navlist.group expandable :expanded="false" heading="Inventario" class="hidden lg:grid">
                <flux:navlist.item href="{{ route('herramientas.index') }}">Herramientas</flux:navlist.item>
            </flux:navlist.group>

            @if(Auth::user() && Auth::user()->hasPermission('user_audit'))
            <flux:navlist.group expandable :expanded="false" heading="Admin" class="hidden lg:grid">
                <flux:navlist.item href="{{ route('register') }}">Crear Usuario</flux:navlist.item>
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
        <flux:dropdown position="top" allign="start" class="max-lg:hidden">
            <flux:profile avatar="" name="{{ Auth::user()->nombre ?? 'Usuario' }}" />
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
        @if(Auth::check())
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

    @livewireScripts
    @fluxScripts
</body>

</html>
