<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Multazim') }} - Storefront</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:500,700&family=ibm-plex-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f4f4f4] font-sans text-[#1f2937] antialiased">
        <header class="bg-white shadow-sm">
            <div class="mx-auto flex w-full max-w-[1240px] flex-col gap-4 px-4 py-4 lg:flex-row lg:items-center lg:justify-between">
                <a href="{{ route('storefront.home') }}" class="flex items-center gap-3">
                    <x-application-logo class="h-12 w-auto" />
                    <div>
                        <p class="font-display text-xl font-bold text-[#ea7c1a]">Multazim</p>
                        <p class="text-xs text-slate-500">Trusted e-commerce storefront</p>
                    </div>
                </a>

                <form action="{{ route('storefront.products.index') }}" method="GET" class="flex w-full max-w-2xl items-center gap-2">
                    <span class="rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-slate-600" aria-hidden="true">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </span>
                    <label for="homepage-search" class="sr-only">Search</label>
                    <input
                        id="homepage-search"
                        name="q"
                        type="search"
                        placeholder="Search products"
                        class="w-full rounded-md border border-slate-200 px-4 py-2.5 text-sm focus:border-[#ea7c1a] focus:ring-[#ea7c1a]"
                    >
                    <button
                        type="submit"
                        class="rounded-md bg-[#ea7c1a] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#d86f13]"
                    >
                        Search
                    </button>
                </form>

                <div class="flex flex-wrap items-center gap-3 text-sm">
                    <a href="tel:01317448899" class="flex items-center gap-2 rounded-md border border-slate-200 px-3 py-2 transition hover:border-[#ea7c1a]">
                        <svg class="h-4 w-4 text-[#ea7c1a]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h2.5a1 1 0 01.97.757l1.2 4.8a1 1 0 01-.29.98l-1.7 1.7a16 16 0 006.59 6.59l1.7-1.7a1 1 0 01.98-.29l4.8 1.2a1 1 0 01.75.97V19a2 2 0 01-2 2h-1C10.82 21 3 13.18 3 3V5z" />
                        </svg>
                        <span>Call Us Now: 01317448899</span>
                    </a>
                    <a href="#" class="rounded-md border border-slate-200 px-3 py-2 transition hover:border-[#ea7c1a]">Wishlist (0)</a>
                    <a href="{{ route('login') }}" class="rounded-md border border-slate-200 px-3 py-2 transition hover:border-[#ea7c1a]">Login/Sign up</a>
                </div>
            </div>

            <nav class="bg-[#ea7c1a]">
                <div class="mx-auto w-full max-w-[1240px] overflow-x-auto px-4">
                    <ul class="flex min-w-max items-center gap-1 py-2 text-sm font-semibold text-white">
                        @foreach ($menuItems as $menuItem)
                            <li>
                                <a
                                    href="{{ $menuItem['url'] }}"
                                    class="inline-flex items-center gap-1 rounded px-3 py-1.5 transition hover:bg-white/15"
                                >
                                    {{ $menuItem['label'] }}
                                    <span aria-hidden="true">v</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
        </header>

        <main class="pb-14">
            <section class="mx-auto mt-4 grid w-full max-w-[1240px] gap-4 px-4 lg:grid-cols-[2fr,1fr]">
                <article class="overflow-hidden rounded-lg border border-slate-200 bg-gradient-to-r from-[#f58b2b] via-[#f2a65c] to-[#f7c998]">
                    <div class="flex min-h-[280px] flex-col justify-between gap-8 p-8 text-white">
                        <div>
                            <p class="text-xs uppercase tracking-[0.28em] text-orange-100">Winter Campaign</p>
                            <h1 class="mt-3 max-w-xl font-display text-4xl font-bold leading-tight">Original products. Fast delivery. Trusted support.</h1>
                            <p class="mt-3 max-w-lg text-sm text-orange-100">
                                Multazim storefront now in your Laravel app, with curated categories and product lanes ready for checkout.
                            </p>
                        </div>
                        <div class="flex items-center justify-between">
                            <a
                                href="{{ route('storefront.products.index') }}"
                                class="rounded-md bg-white px-5 py-2.5 text-sm font-semibold text-[#ea7c1a] transition hover:bg-orange-50"
                            >
                                Shop Now
                            </a>
                            <div class="flex items-center gap-2" aria-label="slider indicators">
                                <span class="h-2.5 w-2.5 rounded-full bg-white"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-white/50"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-white/50"></span>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                    <article class="rounded-lg border border-slate-200 bg-white p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Daily Offer</p>
                        <h2 class="mt-2 text-lg font-bold text-slate-900">Get up to 40% off selected picks</h2>
                        <p class="mt-2 text-sm text-slate-600">Fresh discounts across gadgets, fashion, and essentials.</p>
                    </article>
                    <article class="rounded-lg border border-slate-200 bg-white p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Support</p>
                        <h2 class="mt-2 text-lg font-bold text-slate-900">Cash on delivery available</h2>
                        <p class="mt-2 text-sm text-slate-600">Secure order placement with fast customer service.</p>
                    </article>
                </div>
            </section>

            <section class="mx-auto mt-6 w-full max-w-[1240px] px-4">
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-slate-900">Categories</h2>
                        <a href="#" class="text-sm font-semibold text-[#ea7c1a] hover:underline">View All</a>
                    </div>
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:grid-cols-8">
                        @foreach ($categoryItems as $categoryItem)
                            <a href="{{ $categoryItem['url'] }}" class="group flex flex-col items-center rounded-lg border border-slate-200 p-3 text-center transition hover:border-[#ea7c1a] hover:bg-orange-50">
                                <span class="mb-2 flex h-14 w-14 items-center justify-center rounded-full bg-orange-100 text-lg font-bold text-[#ea7c1a]">
                                    {{ substr($categoryItem['label'], 0, 1) }}
                                </span>
                                <span class="text-xs font-semibold text-slate-700 group-hover:text-[#ea7c1a]">{{ $categoryItem['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            @foreach ($productSections as $section)
                <section class="mx-auto mt-6 w-full max-w-[1240px] px-4">
                    <div class="rounded-lg border border-slate-200 bg-white p-5">
                        <h2 class="mb-4 text-2xl font-bold text-slate-900">{{ $section['title'] }}</h2>

                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            @forelse ($section['products'] as $product)
                                @php
                                    $image = $product->images->first();
                                @endphp

                                <article class="overflow-hidden rounded-lg border border-slate-200 bg-white transition hover:shadow-lg">
                                    <a href="{{ route('storefront.products.show', $product) }}" class="block bg-slate-100">
                                        @if ($image)
                                            <img
                                                class="h-52 w-full object-cover"
                                                src="{{ \Illuminate\Support\Facades\Storage::disk('products')->url($image->path) }}"
                                                alt="{{ $image->alt_text ?? $product->name }}"
                                                loading="lazy"
                                                decoding="async"
                                            >
                                        @else
                                            <div class="flex h-52 items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-sm font-medium text-slate-500">
                                                Image coming soon
                                            </div>
                                        @endif
                                    </a>

                                    <div class="p-4">
                                        <h3 class="line-clamp-2 min-h-[48px] text-sm font-semibold text-slate-800">
                                            <a href="{{ route('storefront.products.show', $product) }}">{{ $product->name }}</a>
                                        </h3>
                                        <p class="mt-2 text-base font-bold text-[#ea7c1a]">{{ rtrim(rtrim((string) $product->price, '0'), '.') }} TK</p>
                                        <a
                                            href="{{ route('storefront.products.show', $product) }}"
                                            class="mt-3 inline-flex w-full items-center justify-center rounded-md bg-[#ea7c1a] px-3 py-2 text-sm font-semibold text-white transition hover:bg-[#d86f13]"
                                        >
                                            Order Now
                                        </a>
                                    </div>
                                </article>
                            @empty
                                <article class="col-span-full rounded-lg border border-dashed border-slate-300 p-8 text-center text-slate-500">
                                    Active products will appear here once catalog items are available.
                                </article>
                            @endforelse
                        </div>
                    </div>
                </section>
            @endforeach

            <section class="mx-auto mt-6 w-full max-w-[1240px] px-4">
                <div class="grid gap-3 rounded-lg border border-slate-200 bg-white p-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($serviceHighlights as $serviceHighlight)
                        <article class="rounded-md border border-slate-200 bg-[#f8fafc] p-4">
                            <p class="text-sm font-bold text-slate-900">{{ $serviceHighlight['title'] }}</p>
                            <p class="mt-1 text-sm text-slate-600">{{ $serviceHighlight['description'] }}</p>
                        </article>
                    @endforeach
                </div>
            </section>
        </main>

        <footer class="bg-[#111827] text-slate-100">
            <div class="mx-auto grid w-full max-w-[1240px] gap-8 px-4 py-10 md:grid-cols-2 lg:grid-cols-4">
                <section>
                    <a href="{{ route('storefront.home') }}" class="inline-flex items-center gap-3">
                        <x-application-logo class="h-12 w-auto" />
                        <span class="font-display text-xl font-bold text-white">Multazim</span>
                    </a>
                    <p class="mt-3 text-sm text-slate-300">www.multazim.com</p>
                </section>

                <section>
                    <h3 class="text-lg font-semibold text-white">Quick Links</h3>
                    <ul class="mt-3 space-y-2 text-sm text-slate-300">
                        @foreach ($quickLinks as $quickLink)
                            <li><a href="{{ $quickLink['url'] }}" class="transition hover:text-white">{{ $quickLink['label'] }}</a></li>
                        @endforeach
                    </ul>
                </section>

                <section>
                    <h3 class="text-lg font-semibold text-white">Information</h3>
                    <ul class="mt-3 space-y-2 text-sm text-slate-300">
                        @foreach ($informationLinks as $informationLink)
                            <li><a href="{{ $informationLink['url'] }}" class="transition hover:text-white">{{ $informationLink['label'] }}</a></li>
                        @endforeach
                    </ul>
                </section>

                <section>
                    <h3 class="text-lg font-semibold text-white">Follow Us</h3>
                    <div class="mt-3 rounded-md border border-slate-700 bg-[#0f172a] p-4 text-sm text-slate-300">
                        <p class="font-semibold text-white">Multazim - Facebook</p>
                        <p class="mt-1">1,950+ followers</p>
                        <a href="https://www.facebook.com/multazimbd/" class="mt-3 inline-flex rounded-md bg-[#ea7c1a] px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-[#d86f13]">
                            Follow Page
                        </a>
                    </div>
                </section>
            </div>
            <div class="border-t border-slate-700 py-4">
                <div class="mx-auto flex w-full max-w-[1240px] flex-wrap items-center justify-between gap-2 px-4 text-xs text-slate-300">
                    <p>www.multazim.com</p>
            <p>Developed by MIT</p>
                </div>
            </div>
        </footer>

        <a
            href="{{ route('storefront.cart.index') }}"
            class="fixed bottom-24 right-4 z-20 inline-flex items-center gap-2 rounded-full bg-[#ea7c1a] px-4 py-2 text-sm font-semibold text-white shadow-lg transition hover:bg-[#d86f13]"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l1.2 6M7 13h10l3-8H6.2M7 13l-1.5 5h13M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
            </svg>
            0 items
        </a>

        <a
            href="https://wa.me/+8801317448899"
            class="fixed bottom-6 right-4 z-20 inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#25d366] text-xl text-white shadow-lg transition hover:bg-[#1cb859]"
            aria-label="Chat on WhatsApp"
        >
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.6 13.4c-.3-.2-1.6-.8-1.8-.9-.2-.1-.4-.2-.6.2-.2.3-.7.9-.8 1.1-.2.2-.3.2-.6.1a7.2 7.2 0 01-2.1-1.3 8.1 8.1 0 01-1.5-1.9c-.2-.3 0-.4.1-.6.1-.1.2-.3.3-.4.1-.1.2-.3.3-.5.1-.2 0-.4 0-.6 0-.2-.6-1.5-.9-2-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.4-.2.2-.9.9-.9 2.1 0 1.2.9 2.4 1 2.6.1.2 1.7 2.7 4.1 3.7.6.3 1 .5 1.4.6.6.2 1.1.2 1.5.1.5-.1 1.6-.7 1.8-1.4.2-.7.2-1.3.1-1.4-.1-.1-.3-.2-.6-.3z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12a8 8 0 10-14.9 4l-1.1 4.1L8.2 19A8 8 0 0020 12z" />
            </svg>
        </a>
    </body>
</html>
