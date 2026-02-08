<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Multazim') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&family=ibm-plex-sans:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-sand-50 text-ink-900">
        <div class="min-h-screen flex flex-col">
            <header class="border-b border-sand-200/70 bg-sand-50/90 backdrop-blur">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="flex h-16 items-center justify-between gap-4">
                        <a href="{{ route('storefront.home') }}" class="flex items-center gap-3">
                            <x-application-logo class="h-9 w-auto" />
                            <span class="font-display text-lg text-ink-900">Multazim</span>
                        </a>

                        <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-muted">
                            <a class="transition hover:text-ink-900" href="{{ route('storefront.products.index') }}">Products</a>
                            <a class="transition hover:text-ink-900" href="{{ route('storefront.checkout.show') }}">Checkout</a>
                        </nav>

                        <div class="flex items-center gap-3 text-sm font-medium">
                            <a class="rounded-full border border-sand-200 px-3 py-1.5 text-ink-700 transition hover:border-sand-300 hover:text-ink-900" href="{{ route('storefront.cart.index') }}">Cart</a>
                            @auth
                                <a class="rounded-full bg-accent-600 px-3 py-1.5 text-white transition hover:bg-accent-700" href="{{ route('dashboard') }}">Dashboard</a>
                                @if (Auth::user()->role === 'admin')
                                    <a class="rounded-full border border-accent-600 px-3 py-1.5 text-accent-700 transition hover:bg-accent-50" href="{{ route('admin.dashboard') }}">Admin</a>
                                @endif
                            @else
                                <a class="rounded-full bg-accent-600 px-3 py-1.5 text-white transition hover:bg-accent-700" href="{{ route('login') }}">Sign in</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="border-t border-sand-200/70 bg-sand-50">
                <div class="max-w-7xl mx-auto px-6 py-8 text-sm text-muted">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <span class="font-display text-ink-900">Multazim</span>
                        <span>Minimal, fast, and built for daily operations.</span>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
