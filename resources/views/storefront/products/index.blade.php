<x-storefront-layout>
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 sm:py-10">
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-muted">Storefront</p>
                <h1 class="font-display text-3xl text-ink-900">Products</h1>
                <p class="mt-1 text-sm text-muted">Browse, filter, and add items in one pass.</p>
            </div>
            <a
                class="rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-ink-700 transition hover:border-sand-300 hover:text-ink-900 ui-ring"
                href="{{ route('storefront.cart.index') }}"
            >
                View cart
            </a>
        </div>

        <x-ui.card class="mb-6" title="Filter catalog" description="Narrow the list by stock and sort order.">
            <form method="GET" action="{{ route('storefront.products.index') }}" class="grid gap-3 md:grid-cols-[1fr,180px,220px,auto] md:items-end">
                <div>
                    <x-input-label for="q" :value="__('Search')" />
                    <x-text-input
                        id="q"
                        class="mt-1 w-full"
                        type="search"
                        name="q"
                        :value="$filters->search"
                        placeholder="Search by name or description"
                    />
                </div>

                <div>
                    <x-input-label for="stock" :value="__('Stock')" />
                    <x-select-input id="stock" name="stock" class="mt-1 w-full">
                        @foreach ($stockOptions as $stockOption)
                            <option value="{{ $stockOption->value }}" @selected($filters->stock === $stockOption)>
                                {{ $stockOption->label() }}
                            </option>
                        @endforeach
                    </x-select-input>
                </div>

                <div>
                    <x-input-label for="sort" :value="__('Sort')" />
                    <x-select-input id="sort" name="sort" class="mt-1 w-full">
                        @foreach ($sortOptions as $sortOption)
                            <option value="{{ $sortOption->value }}" @selected($filters->sort === $sortOption)>
                                {{ $sortOption->label() }}
                            </option>
                        @endforeach
                    </x-select-input>
                </div>

                <div class="flex gap-2 md:justify-end">
                    <x-primary-button>Apply</x-primary-button>
                    <a
                        class="inline-flex items-center rounded-xl border border-sand-200 bg-white px-4 py-2 text-sm font-semibold text-ink-700 shadow-sm transition hover:bg-sand-100 ui-ring"
                        href="{{ route('storefront.products.index') }}"
                    >
                        Reset
                    </a>
                </div>
            </form>
        </x-ui.card>

        <div class="mb-4 flex items-center justify-between gap-3 text-sm">
            <p class="text-muted">{{ $products->total() }} products found</p>
            @if ($filters->hasSearch())
                <x-ui.badge variant="accent">Search: {{ $filters->search }}</x-ui.badge>
            @endif
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($products as $product)
                <x-storefront.product-card :product="$product" />
            @empty
                <x-ui.empty-state
                    title="No products found"
                    description="Try adjusting your search, stock filter, or sort selection."
                />
            @endforelse
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-storefront-layout>
