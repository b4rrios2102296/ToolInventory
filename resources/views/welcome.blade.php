<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ToolInventory</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|athelas:400" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<script>
    // Interceptar clicks en enlaces
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a[href]');
        if (!link) return;
        
        // Ignorar enlaces externos o con target="_blank"
        if (link.target === '_blank' || 
            link.hostname !== window.location.hostname) {
            return;
        }
        
        e.preventDefault();
        const exitOverlay = document.createElement('div');
        exitOverlay.className = 'page-exit';
        document.body.appendChild(exitOverlay);
        
        // Forzar repaint
        void exitOverlay.offsetWidth;
        
        // Activar transición
        exitOverlay.classList.add('active');
        
        // Navegar después de la transición
        setTimeout(() => {
            window.location.href = link.href;
        }, 100);
    });
</script>
    <style>
     .page-transition {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff; /* Usa tu color de fondo principal */
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }
        
        .page-transition.active {
            opacity: 1;
        }
        
        /* Animación de entrada */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        body {
            animation: fadeIn 0.4s ease-out;
        }

        body {
            background-image: url('/Images/workshop-4863393_1280.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: -1;
        }

        .auth-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
            width: 100%;
        }

        .brand-logo {
            width: 500px;
            margin-bottom: 1.5rem;
        }

        .auth-card {
            width: 300px;
            /* Smaller than logo */
            margin-top: 1.5rem;
            background: transparent;
            backdrop-filter: none;
            border: none;
            padding: 0;
        }

        .auth-button {
            display: block;
            width: 100%;
            padding: 0.8rem;
            text-align: center;
            color: white;
            background-color: #A4957D;
            border: 1px solid #A4957D;
            border-radius: 0.3rem;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .auth-button:hover {
            background-color: #8a7c66;
            border-color: #8a7c66;
            transform: translateY(-2px);
        }
    </style>
        @stack('styles')

</head>

<body>
    <div class="auth-container">
        <img src="{{ asset('Images/TLW.svg') }}" alt="ToolInventory Logo" class="brand-logo" />

        <div class="auth-card">
            @if (Route::has('login'))
                <nav class="flex flex-col gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="auth-button">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="auth-button">
                            Iniciar Sesión
                        </a>
                    @endauth
                </nav>
            @endif
        </div>
    </div>
</body>

</html>