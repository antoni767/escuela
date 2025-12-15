<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido | Cargando sistema</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Entrada general */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Zoom suave del logo */
        @keyframes logoZoom {
            0% {
                transform: scale(0.95);
            }
            50% {
                transform: scale(1.03);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Spinner */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Pulso tipo Filament */
        @keyframes pulseText {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.6;
            }
        }

        .fade-in {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .logo-animate {
            animation: logoZoom 2.5s ease-in-out infinite;
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 3px solid #d1d5db;
            border-top-color: #22c55e;
            border-radius: 50%;
            animation: spin 0.9s linear infinite;
        }

        .pulse {
            animation: pulseText 1.6s infinite;
        }

        /* Barra de progreso */
        .progress-bar {
            width: 100%;
            background-color: #e5e7eb;
            border-radius: 9999px;
            overflow: hidden;
            height: 14px;
        }

        .progress {
            height: 100%;
            width: 0%;
            background-color: #22c55e;
            transition: width 0.6s ease-in-out;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="text-center w-full max-w-md px-6 fade-in">

        <!-- TÍTULO -->
        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Bienvenido al Sistema
        </h1>

        <!-- LOGO -->
        <div class="flex justify-center mb-6">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="Logo"
                class="h-24 w-auto logo-animate"
            >
        </div>

        <!-- TEXTO + SPINNER -->
        <div class="flex items-center justify-center gap-3 mb-4">
            <div class="spinner"></div>
            <p id="statusText" class="text-gray-600 text-lg pulse">
                Cargando sistema...
            </p>
        </div>

        <!-- BARRA DE PROGRESO -->
        <div class="progress-bar mb-6">
            <div id="progress" class="progress"></div>
        </div>

        <!-- MENSAJE EXTRA -->
        <p class="text-sm text-gray-500">
            Por favor espere unos segundos
        </p>

    </div>

    <!-- SCRIPT DE CARGA -->
    <script>
        const steps = [
            'Cargando sistema...',
            'Inicializando módulos...',
            'Cargando base de datos...',
            'Verificando configuración...',
            'Preparando interfaz...',
            '¡Listo!'
        ];

        let currentStep = 0;
        const progress = document.getElementById('progress');
        const statusText = document.getElementById('statusText');

        const interval = setInterval(() => {
            if (currentStep < steps.length) {
                statusText.textContent = steps[currentStep];
                progress.style.width =
                    ((currentStep + 1) / steps.length * 100) + '%';
                currentStep++;
            } else {
                clearInterval(interval);

                statusText.classList.remove('pulse');
                statusText.textContent = 'Redirigiendo...';

                setTimeout(() => {
                    window.location.href =
                        "{{ route('filament.admin.auth.login') }}";
                }, 900);
            }
        }, 1000);
    </script>

</body>
</html>
