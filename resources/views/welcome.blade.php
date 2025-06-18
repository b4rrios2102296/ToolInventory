<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@fluxAppearance

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ToolInventory</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|athelas:400" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v={{ time() }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        




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
            pointer-events: none;
            user-select: none;
            -webkit-user-drag: none;
            width: 900px;
        }


        .auth-card {
            align-items: center;
            width: 300px;
            /* Smaller than logo */
            margin-top: -5.4rem;
            background: transparent;
            backdrop-filter: none;
            border: none;
            padding: 0;
            margin-bottom: 30px;
        }

        .auth-button {
            align-items: center;
            width: 100%;
            padding: 0.9rem;
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
        }
    </style>
    @stack('styles')

</head>

<body class="min-h-screen flex items-center justify-center">
    <div>
        <img src="{{ asset('Images/Assets-velasresorts9.png') }}"
            style="position: absolute; top: 20px; left: 20px; width: 150px; height: auto;" />
    </div>

    <div class="auth-container">
        <div>
            <img src="{{ asset('Images/TLW.svg') }}" alt="ToolInventory Logo" class="brand-logo" />

        </div>

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