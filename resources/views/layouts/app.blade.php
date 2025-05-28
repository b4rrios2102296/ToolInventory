<!-- filepath: c:\xampp\htdocs\ToolInventory\resources\views\layouts\app.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Dashboard</title>

    <!-- Fuentes y estilos -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="/faviconcircle16x16.png" type="image/png" sizes="16x16">
    <link rel="icon" href="/faviconcircle32x32.png" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="/apple-touch-icon-circle.png" sizes="180x180">
    <meta name="algolia-site-verification" content="A39CBDEB76ED91E0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3" />
    <script src="https://cdn.usefathom.com/script.js" data-site="KGGYBJLC" defer></script>
    <meta name="title" content="Flux · Livewire UI kit" />
    <meta name="description" content="The official Livewire component library. Built by the folks behind Livewire and Alpine." />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="og:title" content="Flux · Livewire UI kit" />
    <meta name="og:description" content="The official Livewire component library. Built by the folks behind Livewire and Alpine." />
    <meta name="og:image" content="https://fluxui.dev/img/og_image.jpg" />

    @fluxAppearance
    @livewireStyles

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @font-face {
            font-family: 'Monolisa';
            src: url('/fonts/MonoLisa-Regular.woff2') format('woff2'),
                url('/fonts/MonoLisa-Regular.woff') format('woff');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'Monolisa';
            src: url('/fonts/MonoLisa-Medium.woff2') format('woff2'),
                url('/fonts/MonoLisa-Medium.woff') format('woff');
            font-weight: 500;
            font-style: normal;
        }

        :root.dark {
            color-scheme: dark;
        }

        flux\\:sidebar {
            background-color: #321F01 !important;
            color: #FFF5E6 !important;
        }

        flux\\:sidebar *,
        flux\\:sidebar .icon,
        flux\\:sidebar svg,
        flux\\:sidebar [class^="icon-"] {
            color: #FFF5E6 !important;
            fill: #FFF5E6 !important;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    <link rel="preload" as="style" href="https://fluxui.dev/build/assets/app-Cu53mo6u.css" />
    <link rel="stylesheet" href="https://fluxui.dev/build/assets/app-Cu53mo6u.css" data-navigate-track="reload" />

    <script>
        window.Flux = {
            applyAppearance(appearance) {
                let applyDark = () => document.documentElement.classList.add('dark')
                let applyLight = () => document.documentElement.classList.remove('dark')
                if (appearance === 'system') {
                    let media = window.matchMedia('(prefers-color-scheme: dark)')
                    window.localStorage.removeItem('flux.appearance')
                    media.matches ? applyDark() : applyLight()
                } else if (appearance === 'dark') {
                    window.localStorage.setItem('flux.appearance', 'dark')
                    applyDark()
                } else if (appearance === 'light') {
                    window.localStorage.setItem('flux.appearance', 'light')
                    applyLight()
                }
            }
        }
        window.Flux.applyAppearance(window.localStorage.getItem('flux.appearance') || 'system')
    </script>

    <style>
        [wire\:loading], [wire\:loading.delay], [wire\:loading.inline-block],
        [wire\:loading.inline], [wire\:loading.block], [wire\:loading.flex],
        [wire\:loading.table], [wire\:loading.grid], [wire\:loading.inline-flex],
        [wire\:loading.delay.none], [wire\:loading.delay.shortest],
        [wire\:loading.delay.shorter], [wire\:loading.delay.short],
        [wire\:loading.delay.default], [wire\:loading.delay.long],
        [wire\:loading.delay.longer], [wire\:loading.delay.longest],
        [wire\:offline], [wire\:dirty]:not(textarea):not(input):not(select) {
            display: none;
        }

        :root {
            --livewire-progress-bar-color: #2299dd;
        }
    </style>
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <!-- Sidebar -->
    <flux:sidebar sticky stashable
        class="bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700"
        style="background-color: #321F01 !important; color: #FFF5E6 !important;">
        
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
            <flux:navlist.item icon="cog" href="{{ route('dashboard') }}">Dashboard</flux:navlist.item>
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
        <flux:dropdown position="top" align="start" class="max-lg:hidden">
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
        <flux:dropdown position="top" align="start">
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
