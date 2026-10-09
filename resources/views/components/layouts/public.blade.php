<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $titulo ?? 'Herramientas' }} - {{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css'])
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900 min-h-screen flex flex-col">
        <header class="bg-gray-900">
            <div class="max-w-3xl mx-auto px-4 py-4">
                <a href="{{ url('/') }}" class="text-white font-semibold tracking-wide">GCE</a>
            </div>
        </header>

        <main class="flex-1">
            <div class="max-w-3xl mx-auto px-4 py-10">
                {{ $slot }}
            </div>
        </main>

        <footer class="text-center text-xs text-gray-400 py-6">
            &copy; {{ now()->year }} Grupo Comercial Empresarial
        </footer>

        @vite(['resources/js/app.js'])
        @stack('scripts')
    </body>
</html>
