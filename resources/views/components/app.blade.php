<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-950 text-zinc-200">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title . ' | Reeltrack' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800,900" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @livewireStyles
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

</head>

<body class="font-sans antialiased flex flex-col min-h-screen">
<!-- Header -->
@include('layouts.header')

<!-- Main Content -->
<main class="grow">
    {{ $slot }}
</main>

<!-- Footer -->
@include('layouts.footer')
@livewireScripts
</body>
