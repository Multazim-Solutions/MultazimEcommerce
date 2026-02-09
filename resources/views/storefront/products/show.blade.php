<x-storefront-layout>
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 sm:py-10">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <a class="text-sm font-medium text-muted hover:text-ink-900 ui-ring" href="{{ route('storefront.products.index') }}">Back to products</a>
            <a class="rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-ink-700 transition hover:border-sand-300 hover:text-ink-900 ui-ring" href="{{ route('storefront.cart.index') }}">View cart</a>
        </div>

        @php
            $images = $product->images->sortBy('sort_order')->values();
            $fallbackImage = '/brand/multazim_logo.png';
            $hasStock = $product->stock_qty > 0;
            $initialImage = $images->first()?->path ? \Illuminate\Support\Facades\Storage::disk('products')->url($images->first()->path) : $fallbackImage;
            $initialAlt = $images->first()?->alt_text ?? $product->name;
        @endphp

        <div class="grid gap-6 lg:grid-cols-[1.1fr,1fr]">
            <section
                class="rounded-2xl border border-sand-200 bg-white/90 p-4 shadow-elev-1"
                x-data="{ selected: {{ \Illuminate\Support\Js::from($initialImage) }}, alt: {{ \Illuminate\Support\Js::from($initialAlt) }} }"
            >
                <div class="overflow-hidden rounded-xl bg-sand-100">
                    <img
                        class="h-72 w-full object-cover sm:h-96"
                        :src="selected"
                        :alt="alt"
                        loading="eager"
                        decoding="async"
                    >
                </div>

                @if ($images->isNotEmpty())
                    <div class="mt-3 grid grid-cols-4 gap-2 sm:grid-cols-5">
                        @foreach ($images as $image)
                            @php
                                $imageUrl = \Illuminate\Support\Facades\Storage::disk('products')->url($image->path);
                            @endphp
                            <button
                                type="button"
                                class="overflow-hidden rounded-lg border border-sand-200 bg-white ui-ring"
                                x-on:click="selected = {{ \Illuminate\Support\Js::from($imageUrl) }}; alt = {{ \Illuminate\Support\Js::from($image->alt_text ?? $product->name) }};"
                                aria-label="Show gallery image {{ $loop->iteration }}"
                            >
                                <img class="h-16 w-full object-cover" src="{{ $imageUrl }}" alt="{{ $image->alt_text ?? $product->name }}" loading="lazy" decoding="async">
                            </button>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="rounded-2xl border border-sand-200 bg-white/90 p-6 shadow-elev-1">
                <div class="mb-3 flex flex-wrap items-center gap-2">
                    <x-ui.badge :variant="$hasStock ? 'success' : 'warning'">
                        {{ $hasStock ? 'In stock' : 'Out of stock' }}
                    </x-ui.badge>
                    <span class="text-sm text-muted">{{ $product->stock_qty }} units available</span>
                </div>

                <h1 class="font-display text-3xl text-ink-900">{{ $product->name }}</h1>
                <p class="mt-3 text-muted">{{ $product->description }}</p>

                <div class="mt-6 text-2xl font-semibold text-ink-900">
                    {{ $product->currency }} {{ number_format((float) $product->price, 2) }}
                </div>

                <form class="mt-6 flex flex-wrap items-end gap-3" method="POST" action="{{ route('storefront.cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div>
                        <x-input-label for="qty" :value="__('Quantity')" />
                        <x-text-input
                            id="qty"
                            class="mt-1 w-24"
                            type="number"
                            min="1"
                            name="qty"
                            :value="old('qty', '1')"
                            :max="$hasStock ? (string) $product->stock_qty : null"
                            :disabled="!$hasStock"
                        />
                    </div>

                    @if ($hasStock)
                        <x-primary-button>Add to cart</x-primary-button>
                    @else
                        <x-secondary-button type="button" disabled>Out of stock</x-secondary-button>
                    @endif
                </form>
            </section>
        </div>
    </div>
</x-storefront-layout>
