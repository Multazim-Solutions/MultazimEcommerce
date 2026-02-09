@props([
    'product',
])

@php
    /** @var \App\Models\Product $product */
    $image = $product->images->sortBy('sort_order')->first();
    $imagePath = $image?->path;
    $productsDisk = \Illuminate\Support\Facades\Storage::disk('products');
    $hasProductImage = $imagePath !== null && $imagePath !== '' && $productsDisk->exists($imagePath);
    $productImageUrl = $hasProductImage ? $productsDisk->url($imagePath) : asset('brand/multazim_logo.png');
    $hasStock = $product->stock_qty > 0;
@endphp

<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-sand-200 bg-white/90 shadow-elev-1 transition hover:-translate-y-0.5 hover:border-sand-300 hover:shadow-elev-2">
    <div class="relative h-48 overflow-hidden bg-sand-100">
        <img
            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
            src="{{ $productImageUrl }}"
            alt="{{ $image?->alt_text ?? $product->name }}"
            loading="lazy"
            decoding="async"
        >
    </div>

    <div class="flex flex-1 flex-col p-5">
        <div class="mb-3 flex items-start justify-between gap-3">
            <h2 class="text-lg font-semibold text-ink-900">
                <a class="ui-ring rounded-sm" href="{{ route('storefront.products.show', $product) }}">
                    {{ $product->name }}
                </a>
            </h2>
            <x-ui.badge :variant="$hasStock ? 'success' : 'warning'">
                {{ $hasStock ? 'In stock' : 'Out of stock' }}
            </x-ui.badge>
        </div>

        <p class="line-clamp-3 text-sm text-muted">{{ $product->description }}</p>

        <div class="mt-4 flex items-center justify-between">
            <span class="text-base font-semibold text-ink-900">
                {{ $product->currency }} {{ number_format((float) $product->price, 2) }}
            </span>
            <span class="text-xs text-muted">{{ $product->stock_qty }} available</span>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-2">
            @if ($hasStock)
                <form method="POST" action="{{ route('storefront.cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="qty" value="1">
                    <x-primary-button aria-label="Add {{ $product->name }} to cart">Add to cart</x-primary-button>
                </form>
            @else
                <x-secondary-button type="button" disabled>Unavailable</x-secondary-button>
            @endif

            <a
                class="inline-flex items-center rounded-xl border border-sand-200 px-3 py-2 text-sm font-semibold text-ink-700 transition hover:bg-sand-100 ui-ring"
                href="{{ route('storefront.products.show', $product) }}"
            >
                Details
            </a>
        </div>
    </div>
</article>
