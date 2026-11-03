<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tienda</title>
    @livewireStyles
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans">
<header class="relative border-b border-neutral-200 bg-white dark:border-neutral-800 dark:bg-neutral-950">
    <nav>
        <div class="mx-auto flex h-16 max-w-7xl items-center gap-2 px-4 md:px-8">
            <div>
                <ul class="flex flex-col gap-1 p-4 lg:flex-row lg:items-center lg:gap-7 lg:p-0">
                    <li><a href="/" class="flex items-center font-medium">Inicio</a></li>
                    <li><a href="/" class="flex items-center font-medium">Productos</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
{{ $slot }}
@livewireScripts
</body>
</html>
