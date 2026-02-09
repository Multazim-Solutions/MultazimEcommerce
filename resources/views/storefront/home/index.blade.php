<x-storefront-layout>
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 sm:py-10 space-y-8">
        <section class="rounded-2xl border border-sand-200 bg-white/90 p-4 shadow-elev-1 sm:p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-display text-xl text-ink-900">Promotions</h2>
                <a href="{{ route('storefront.products.index') }}" class="text-sm font-semibold text-accent-700 hover:text-accent-800">Shop now</a>
            </div>

            <div class="flex snap-x snap-mandatory gap-4 overflow-x-auto pb-1 md:grid md:grid-cols-3 md:overflow-visible md:pb-0">
                @foreach ($promotionalSlides as $promotionalSlide)
                    <article class="group relative min-w-[280px] snap-start overflow-hidden rounded-xl border border-sand-200 bg-white shadow-sm sm:min-w-[340px] md:min-w-0">
                        <img
                            src="{{ $promotionalSlide['image_url'] }}"
                            alt="{{ $promotionalSlide['heading'] }}"
                            class="h-44 w-full object-cover sm:h-52"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-ink-900/75 via-ink-900/30 to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-4">
                            <p class="text-[11px] uppercase tracking-[0.2em] text-white/80">Promotional Banner</p>
                            <h3 class="mt-1 text-lg font-semibold text-white">{{ $promotionalSlide['heading'] }}</h3>
                            <p class="mt-1 text-sm text-white/90">{{ $promotionalSlide['subheading'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl border border-sand-200 bg-white/90 p-5 shadow-elev-1 sm:p-6">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-muted">Catalog</p>
                    <h2 class="font-display text-2xl text-ink-900">Categories</h2>
                </div>
                <a href="{{ route('storefront.categories.index') }}" class="text-sm font-semibold text-accent-700 hover:text-accent-800">View all</a>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-8">
                @forelse ($featuredCategories as $featuredCategory)
                    <a
                        href="{{ route('storefront.categories.index') }}#category-{{ $featuredCategory->id }}"
                        class="group rounded-xl border border-sand-200 bg-white p-2 text-center transition hover:border-accent-400 hover:shadow-sm"
                    >
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-lg bg-primary-50 text-xl font-bold text-primary-800">
                            {{ \Illuminate\Support\Str::substr($featuredCategory->name, 0, 1) }}
                        </div>
                        <p class="mt-2 line-clamp-2 text-xs font-semibold text-ink-800 group-hover:text-ink-900">
                            {{ $featuredCategory->name }}
                        </p>
                        <p class="mt-1 text-[11px] text-muted">{{ $featuredCategory->children_count }} subcategories</p>
                    </a>
                @empty
                    <x-ui.empty-state title="No categories yet" description="Seed category data to populate this section." />
                @endforelse
            </div>
        </section>

        @foreach ($productSections as $section)
            <section class="rounded-2xl border border-sand-200 bg-white/90 p-5 shadow-elev-1 sm:p-6">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <h2 class="font-display text-2xl text-ink-900">{{ $section['title'] }}</h2>
                    <a href="{{ route('storefront.products.index') }}" class="text-sm font-semibold text-accent-700 hover:text-accent-800">See more</a>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @forelse ($section['products'] as $product)
                        <x-storefront.product-card :product="$product" />
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
