<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue", 'resources/css/app.css'])
    @inertiaHead
</head>

<body class="bg-woodsmoke-800 dark:bg-woodsmoke-950 text-woodsmoke-950 dark:text-timberwolf-50 font-inter transition-colors duration-theme-change">
    <div
        class="fixed top-0 left-0 w-full h-[125%] bg-page-light dark:bg-page-dark transition-colors duration-theme-change">
    </div>
    <div
        class="absolute h-full w-full bg-horizon-light 3xl:bg-2560 2xl:bg-1440 xl:bg-1280 lg:bg-1024 md:bg-800 sm:bg-440 bg-360 bg-top bg-no-repeat">
    </div>
    <div
        class="absolute h-full w-full bg-horizon-dark 3xl:bg-2560 2xl:bg-1440 xl:bg-1280 lg:bg-1024 md:bg-800 sm:bg-440 bg-360 bg-top bg-no-repeat transition-opacity opacity-0 dark:opacity-100 duration-theme-change">
    </div>
    @inertia
</body>

</html>