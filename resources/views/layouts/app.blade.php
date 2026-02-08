<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&family=ibm-plex-sans:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-sand-50 text-ink-900">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="border-b border-sand-200/70 bg-sand-50">
                    <div class="max-w-7xl mx-auto px-6 py-6">
                        <div class="flex items-center justify-between gap-4">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="border-t border-sand-200/70 bg-sand-50">
                <div class="max-w-7xl mx-auto px-6 py-6 text-sm text-muted">
                    <span class="font-display text-ink-900">Multazim</span> — built for fast, calm commerce.
                </div>
            </footer>
        </div>
    </body>
</html>
