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
    <body class="font-sans text-ink-900 antialiased bg-sand-50">
        <div class="min-h-screen grid lg:grid-cols-[1.1fr,1fr]">
            <section class="hidden lg:flex flex-col justify-between bg-ink-900 text-sand-100 px-10 py-12">
                <div class="flex items-center gap-3">
                    <x-application-logo class="h-10 w-auto" />
                    <span class="font-display text-lg text-brand-300">Multazim</span>
                </div>
                <div class="space-y-4">
                    <p class="text-xs uppercase tracking-[0.3em] text-sand-300">Commerce Console</p>
                    <h1 class="font-display text-4xl text-white">Minimal tools for serious commerce.</h1>
                    <p class="text-sm text-sand-200">Fast operations, precise inventory, and a storefront that never drags.</p>
                    <div class="flex items-center gap-3 text-xs text-sand-300">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-brand-400"></span>
                        Low-motion, high-clarity UI
                    </div>
                </div>
                <div class="text-xs text-sand-300">Built around the Multazim mark.</div>
            </section>

            <section class="flex items-center justify-center px-6 py-10">
                <div class="w-full max-w-md">
                    <div class="mb-6 flex items-center gap-3">
                        <a href="/" class="inline-flex items-center gap-3">
                            <x-application-logo class="h-9 w-auto" />
                            <div>
                                <div class="font-display text-lg text-ink-900">Multazim</div>
                                <div class="text-sm text-muted">Account access</div>
                            </div>
                        </a>
                    </div>
                    <div class="rounded-2xl border border-sand-200 bg-white/90 p-6 shadow-elev-1">
                        {{ $slot }}
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>
