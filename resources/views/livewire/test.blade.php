    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Flux · Livewire UI kit</title>

        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        
        <link rel="icon" href="/faviconcircle16x16.png" type="image/png" sizes="16x16">
        <link rel="icon" href="/faviconcircle32x32.png" type="image/png" sizes="32x32">
        <link rel="apple-touch-icon" href="/apple-touch-icon-circle.png" sizes="180x180">

        
        <meta name="algolia-site-verification"  content="A39CBDEB76ED91E0" />

        
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3" />
        
        <!-- Fathom anayltics... -->
        <script src="https://cdn.usefathom.com/script.js" data-site="KGGYBJLC" defer></script>

        
        <meta name="title" content="Flux · Livewire UI kit" />
        <meta name="description" content="The official Livewire component library. Built by the folks behind Livewire and Alpine." />

        
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="og:title" content="Flux · Livewire UI kit" />
        <meta name="og:description" content="The official Livewire component library. Built by the folks behind Livewire and Alpine." />
        <meta name="og:image" content="https://fluxui.dev/img/og_image.jpg" />

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
                src: '/fonts/MonoLisa-Medium.woff2' format('woff2'),
                    '/fonts/MonoLisa-Medium.woff' format('woff');
                font-weight: 500;
                font-style: normal;
            }
        </style>

        <link rel="preload" as="style" href="https://fluxui.dev/build/assets/app-Cu53mo6u.css" /><link rel="stylesheet" href="https://fluxui.dev/build/assets/app-Cu53mo6u.css" data-navigate-track="reload" />    <style>
        :root.dark {
            color-scheme: dark;
        }
    </style>
    <script>
        window.Flux = {
            applyAppearance (appearance) {
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
        <!-- Livewire Styles --><style >[wire\:loading][wire\:loading], [wire\:loading\.delay][wire\:loading\.delay], [wire\:loading\.inline-block][wire\:loading\.inline-block], [wire\:loading\.inline][wire\:loading\.inline], [wire\:loading\.block][wire\:loading\.block], [wire\:loading\.flex][wire\:loading\.flex], [wire\:loading\.table][wire\:loading\.table], [wire\:loading\.grid][wire\:loading\.grid], [wire\:loading\.inline-flex][wire\:loading\.inline-flex] {display: none;}[wire\:loading\.delay\.none][wire\:loading\.delay\.none], [wire\:loading\.delay\.shortest][wire\:loading\.delay\.shortest], [wire\:loading\.delay\.shorter][wire\:loading\.delay\.shorter], [wire\:loading\.delay\.short][wire\:loading\.delay\.short], [wire\:loading\.delay\.default][wire\:loading\.delay\.default], [wire\:loading\.delay\.long][wire\:loading\.delay\.long], [wire\:loading\.delay\.longer][wire\:loading\.delay\.longer], [wire\:loading\.delay\.longest][wire\:loading\.delay\.longest] {display: none;}[wire\:offline][wire\:offline] {display: none;}[wire\:dirty]:not(textarea):not(input):not(select) {display: none;}:root {--livewire-progress-bar-color: #2299dd;}[x-cloak] {display: none !important;}</style>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc." class="px-2 dark:hidden" />
            <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc." class="px-2 hidden dark:flex" />

            <flux:input as="button" variant="filled" placeholder="Search..." icon="magnifying-glass" />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="home" href="#" current>Home</flux:navlist.item>
                <flux:navlist.item icon="inbox" badge="12" href="#">Inbox</flux:navlist.item>
                <flux:navlist.item icon="document-text" href="#">Documents</flux:navlist.item>
                <flux:navlist.item icon="calendar" href="#">Calendar</flux:navlist.item>

                <flux:navlist.group expandable heading="Favorites" class="hidden lg:grid">
                    <flux:navlist.item href="#">Marketing site</flux:navlist.item>
                    <flux:navlist.item href="#">Android app</flux:navlist.item>
                    <flux:navlist.item href="#">Brand guidelines</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>
            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
                <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item>
            </flux:navlist>

            <flux:dropdown position="top" allign="start" class="max-lg:hidden">
                <flux:profile avatar="https://fluxui.dev/img/demo/user.png" name="Olivia Martin" />

                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                        <flux:menu.radio>Truly Delta</flux:menu.radio>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" alignt="start">
                <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />

                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                        <flux:menu.radio>Truly Delta</flux:menu.radio>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <flux:main>
            <flux:heading size="xl" level="1">Good afternoon, Olivia</flux:heading>

            <flux:text class="mb-6 mt-2 text-base">Here's what's new today</flux:text>

            <flux:separator variant="subtle" />
        </flux:main>
        

        @fluxScripts
    </body>