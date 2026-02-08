<x-storefront-layout>
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <a class="text-sm font-medium text-muted hover:text-ink-900" href="{{ route('storefront.products.index') }}">Back to products</a>
            <a class="rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-ink-700 transition hover:border-sand-300 hover:text-ink-900" href="{{ route('storefront.cart.index') }}">View cart</a>
        </div>

        <div class="rounded-2xl border border-sand-200 bg-white/90 p-6 shadow-elev-1">
            <h1 class="font-display text-3xl text-ink-900">{{ $product->name }}</h1>
            <p class="mt-3 text-muted">{{ $product->description }}</p>
            <div class="mt-4 text-lg font-semibold text-ink-900">
                {{ $product->currency }} {{ number_format((float) $product->price, 2) }}
            </div>

            <form class="mt-6 flex items-center gap-3" method="POST" action="{{ route('storefront.cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <x-text-input class="w-20" type="number" min="1" name="qty" value="1" />
                <x-primary-button>Add to cart</x-primary-button>
            </form>
        </div>
    </div>
</x-storefront-layout>
