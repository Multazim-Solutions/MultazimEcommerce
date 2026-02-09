<x-storefront-layout>
    @php
        $fallbackImageUrl = asset('brand/multazim_logo.png');
        $productsDisk = \Illuminate\Support\Facades\Storage::disk('products');
        $resolveProductImageUrl = static function (?string $path) use ($productsDisk, $fallbackImageUrl): string {
            if ($path === null || $path === '' || !$productsDisk->exists($path)) {
                return $fallbackImageUrl;
            }

            return $productsDisk->url($path);
        };
    @endphp

    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 sm:py-10 space-y-8">
        <section class="rounded-3xl border border-sand-200 bg-gradient-to-br from-brand-100 via-sand-50 to-accent-100 p-6 shadow-elev-1 sm:p-8">
            <div class="grid gap-6 lg:grid-cols-[1.3fr,1fr] lg:items-center">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-muted">Storefront</p>
                    <h1 class="mt-3 font-display text-3xl text-ink-900 sm:text-4xl">Multazim Store, Tailwind Edition</h1>
                    <p class="mt-3 max-w-2xl text-sm text-muted sm:text-base">
                        Same storefront data from your own database, now styled only with the shared Tailwind system used across the app.
                    </p>

                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach ($menuItems as $menuItem)
                            <a
                                href="{{ $menuItem['url'] }}"
                                class="rounded-full border border-sand-300 bg-white/80 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:border-accent-400 hover:text-ink-900"
                            >
                                {{ $menuItem['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-sand-200 bg-white/85 p-4 shadow-sm sm:p-5">
                    <form method="GET" action="{{ route('storefront.products.index') }}" class="space-y-3">
                        <div>
                            <x-input-label for="home-search" :value="__('Search Products')" />
                            <x-text-input
                                id="home-search"
                                class="mt-1 block w-full"
                                type="search"
                                name="q"
                                :value="request('q')"
                                placeholder="Search by name or description"
                            />
                        </div>
                        <x-primary-button class="w-full justify-center">Search catalog</x-primary-button>
                    </form>

                    <div class="mt-4 rounded-xl border border-sand-200 bg-sand-100 p-3 text-sm">
                        <p class="font-semibold text-ink-900">Call Us Now</p>
                        <a href="tel:01317448899" class="text-accent-700 hover:text-accent-800">01317448899</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            @forelse ($heroProducts as $heroProduct)
                @php
                    $heroImage = $heroProduct->images->sortBy('sort_order')->first();
                    $heroImageUrl = $resolveProductImageUrl($heroImage?->path);
                @endphp

                <article class="group overflow-hidden rounded-2xl border border-sand-200 bg-white shadow-elev-1 {{ $loop->first ? 'md:col-span-2 md:row-span-2' : '' }}">
                    <a href="{{ route('storefront.products.show', $heroProduct) }}" class="block h-full">
                        <div class="relative h-48 sm:h-56 {{ $loop->first ? 'md:h-full md:min-h-[380px]' : '' }}">
                            <img
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                src="{{ $heroImageUrl }}"
                                alt="{{ $heroImage?->alt_text ?? $heroProduct->name }}"
                                loading="lazy"
                                decoding="async"
                            >
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-ink-900/70 to-transparent p-4">
                                <p class="line-clamp-2 text-sm font-semibold text-white sm:text-base">{{ $heroProduct->name }}</p>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <x-ui.empty-state title="No hero products" description="Add active products with images to populate this area." />
            @endforelse
        </section>

        <section class="rounded-2xl border border-sand-200 bg-white/90 p-5 shadow-elev-1 sm:p-6">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-muted">Catalog</p>
                    <h2 class="font-display text-2xl text-ink-900">Categories</h2>
                </div>
                <a href="{{ route('storefront.products.index') }}" class="text-sm font-semibold text-accent-700 hover:text-accent-800">View all</a>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-8">
                @forelse ($categoryProducts as $categoryProduct)
                    @php
                        $categoryImage = $categoryProduct->images->sortBy('sort_order')->first();
                        $categoryImageUrl = $resolveProductImageUrl($categoryImage?->path);
                    @endphp

                    <a
                        href="{{ route('storefront.products.show', $categoryProduct) }}"
                        class="group rounded-xl border border-sand-200 bg-white p-2 text-center transition hover:border-accent-400 hover:shadow-sm"
                    >
                        <img
                            src="{{ $categoryImageUrl }}"
                            alt="{{ $categoryImage?->alt_text ?? $categoryProduct->name }}"
                            class="mx-auto h-16 w-16 rounded-lg object-cover"
                            loading="lazy"
                            decoding="async"
                        >
                        <p class="mt-2 line-clamp-2 text-xs font-medium text-ink-700 group-hover:text-ink-900">
                            {{ \Illuminate\Support\Str::limit($categoryProduct->name, 34) }}
                        </p>
                    </a>
                @empty
                    <x-ui.empty-state title="No category products" description="Create products to fill this section." />
                @endforelse
            </div>
        </section>

        @foreach ($productSections as $section)
            <section class="rounded-2xl border border-sand-200 bg-white/90 p-5 shadow-elev-1 sm:p-6">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <h2 class="font-display text-2xl text-ink-900">{{ $section['title'] }}</h2>
                    <a href="{{ route('storefront.products.index') }}" class="text-sm font-semibold text-accent-700 hover:text-accent-800">See more</a>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    @forelse ($section['products'] as $product)
                        @php
                            $sortedImages = $product->images->sortBy('sort_order')->values();
                            $primaryImage = $sortedImages->get(0);
                            $primaryImageUrl = $resolveProductImageUrl($primaryImage?->path);
                            $displayPrice = rtrim(rtrim(number_format((float) $product->price, 2, '.', ''), '0'), '.');
                        @endphp

                        <article class="group flex h-full flex-col overflow-hidden rounded-xl border border-sand-200 bg-white transition hover:-translate-y-0.5 hover:border-sand-300 hover:shadow-elev-2">
                            <a href="{{ route('storefront.products.show', $product) }}" class="block overflow-hidden bg-sand-100">
                                <img
                                    src="{{ $primaryImageUrl }}"
                                    alt="{{ $primaryImage?->alt_text ?? $product->name }}"
                                    class="h-48 w-full object-cover transition duration-300 group-hover:scale-105"
                                    loading="lazy"
                                    decoding="async"
                                >
                            </a>

                            <div class="flex flex-1 flex-col p-4">
                                <a href="{{ route('storefront.products.show', $product) }}" class="line-clamp-2 text-sm font-semibold text-ink-900 hover:text-accent-700">
                                    {{ $product->name }}
                                </a>

                                <p class="mt-2 text-base font-bold text-accent-700">{{ $displayPrice }} TK</p>

                                <div class="mt-4 flex items-center gap-2">
                                    <a
                                        href="{{ route('storefront.products.show', $product) }}"
                                        class="inline-flex flex-1 items-center justify-center rounded-xl bg-accent-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-accent-700"
                                    >
                                        Order Now
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <x-ui.empty-state title="No products in this section" description="Add more active products to populate it." />
                    @endforelse
                </div>
            </section>
        @endforeach

        <section class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($serviceHighlights as $serviceHighlight)
                <article class="rounded-xl border border-sand-200 bg-white p-4 shadow-sm">
                    <p class="text-sm font-semibold text-ink-900">{{ $serviceHighlight['title'] }}</p>
                    <p class="mt-1 text-sm text-muted">{{ $serviceHighlight['description'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="rounded-2xl border border-sand-200 bg-white/90 p-5 shadow-elev-1 sm:p-6">
            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <h3 class="font-display text-lg text-ink-900">Quick Links</h3>
                    <ul class="mt-3 space-y-2 text-sm">
                        @foreach ($quickLinks as $quickLink)
                            <li>
                                <a href="{{ $quickLink['url'] }}" class="text-muted hover:text-ink-900">{{ $quickLink['label'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="font-display text-lg text-ink-900">Information</h3>
                    <ul class="mt-3 space-y-2 text-sm">
                        @foreach ($informationLinks as $informationLink)
                            <li>
                                <a href="{{ $informationLink['url'] }}" class="text-muted hover:text-ink-900">{{ $informationLink['label'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="font-display text-lg text-ink-900">Follow Us</h3>
                    <p class="mt-3 text-sm text-muted">Stay updated with new arrivals and offers.</p>
                    <a
                        href="https://www.facebook.com/multazimbd/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-3 inline-flex items-center rounded-xl border border-sand-300 px-3 py-2 text-sm font-semibold text-ink-700 transition hover:border-accent-400 hover:text-ink-900"
                    >
                        Facebook Page
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-storefront-layout>
