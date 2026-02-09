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
        @php
            $categoryNavigation = [
                [
                    'label' => 'Mobile Accessories',
                    'subcategories' => ['Chargers', 'Cables', 'Power Banks', 'Phone Cases'],
                ],
                [
                    'label' => 'T-Shirt',
                    'subcategories' => ['Polo T-Shirts', 'Graphic Tees', 'Basic Tees', 'Long Sleeve'],
                ],
                [
                    'label' => 'Watches',
                    'subcategories' => ['Smart Watches', 'Analog Watches', 'Leather Strap', 'Metal Strap'],
                ],
                [
                    'label' => 'Islamic Corner',
                    'subcategories' => ['Prayer Mats', 'Tasbih', 'Islamic Books', 'Attar'],
                ],
                [
                    'label' => 'Shirts',
                    'subcategories' => ['Formal Shirts', 'Casual Shirts', 'Half Sleeve', 'Full Sleeve'],
                ],
                [
                    'label' => 'Kitchen & Dining',
                    'subcategories' => ['Cookware', 'Storage', 'Dinner Sets', 'Kitchen Tools'],
                ],
                [
                    'label' => 'Health & Beauty',
                    'subcategories' => ['Skin Care', 'Hair Care', 'Grooming', 'Personal Care'],
                ],
                [
                    'label' => 'Electronics',
                    'subcategories' => ['Gadgets', 'Home Electronics', 'Accessories', 'Audio'],
                ],
            ];
        @endphp

        <div class="min-h-screen flex flex-col">
            <header class="border-b border-sand-200/70 bg-sand-50/90 backdrop-blur">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="flex flex-wrap items-center gap-3 py-3">
                        <a href="{{ route('storefront.home') }}" class="flex items-center gap-3">
                            <x-application-logo class="h-9 w-auto" />
                            <span class="font-display text-lg text-ink-900">Multazim</span>
                        </a>

                        <form method="GET" action="{{ route('storefront.products.index') }}" class="min-w-[220px] flex-1">
                            <div class="flex items-center gap-2">
                                <x-text-input
                                    id="global-search"
                                    class="w-full"
                                    type="search"
                                    name="q"
                                    :value="request('q')"
                                    placeholder="Search products"
                                />
                                <x-primary-button class="shrink-0">Search</x-primary-button>
                            </div>
                        </form>

                        <div class="flex items-center gap-3 text-sm font-medium">
                            <a
                                class="inline-flex items-center rounded-full border border-primary-200 bg-primary-50 px-3 py-1.5 font-semibold text-primary-800 transition hover:bg-primary-100 ui-ring"
                                href="tel:01317448899"
                            >
                                Call: 01317448899
                            </a>
                            @guest
                                <a class="rounded-full bg-primary-700 px-3 py-1.5 text-white transition hover:bg-primary-800 ui-ring" href="{{ route('login') }}">Sign in</a>
                            @else
                                <a class="rounded-full bg-primary-700 px-3 py-1.5 text-white transition hover:bg-primary-800 ui-ring" href="{{ route('dashboard') }}">Dashboard</a>
                            @endguest
                        </div>
                    </div>

                    <div class="border-t border-sand-200/70 py-2">
                        <nav class="hidden items-center gap-1 overflow-x-auto md:flex">
                            @foreach ($categoryNavigation as $categoryItem)
                                <div class="group relative shrink-0">
                                    <a
                                        href="{{ route('storefront.products.index', ['q' => $categoryItem['label']]) }}"
                                        class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-medium text-ink-700 transition hover:bg-sand-100 hover:text-ink-900"
                                    >
                                        {{ $categoryItem['label'] }}
                                    </a>

                                    <div class="invisible absolute left-0 top-full z-20 mt-2 w-56 translate-y-1 rounded-xl border border-sand-200 bg-white p-2 opacity-0 shadow-elev-1 transition duration-150 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                                        @foreach ($categoryItem['subcategories'] as $subcategoryItem)
                                            <a
                                                href="{{ route('storefront.products.index', ['q' => $subcategoryItem]) }}"
                                                class="block rounded-lg px-3 py-2 text-sm text-ink-700 transition hover:bg-sand-100 hover:text-ink-900"
                                            >
                                                {{ $subcategoryItem }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </nav>

                        <nav class="flex items-center gap-2 overflow-x-auto text-xs font-medium md:hidden">
                            @foreach ($categoryNavigation as $categoryItem)
                                <a
                                    href="{{ route('storefront.products.index', ['q' => $categoryItem['label']]) }}"
                                    class="shrink-0 rounded-full border border-sand-200 px-3 py-1.5 text-ink-700 transition hover:border-sand-300"
                                >
                                    {{ $categoryItem['label'] }}
                                </a>
                            @endforeach
                        </nav>
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
