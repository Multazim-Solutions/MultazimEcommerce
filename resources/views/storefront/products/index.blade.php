<x-storefront-layout>
    <div class="max-w-6xl mx-auto px-6 py-10">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-muted">Storefront</p>
                <h1 class="font-display text-3xl text-ink-900">Products</h1>
            </div>
            <a class="rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-ink-700 transition hover:border-sand-300 hover:text-ink-900" href="{{ route('storefront.cart.index') }}">View cart</a>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($products as $product)
                <div class="rounded-2xl border border-sand-200 bg-white/90 p-5 shadow-elev-1">
                    <h2 class="text-lg font-semibold text-ink-900">
                        <a href="{{ route('storefront.products.show', $product) }}">
                            {{ $product->name }}
                        </a>
                    </h2>
                    <p class="mt-2 text-sm text-muted">{{ $product->description }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm font-semibold text-ink-900">{{ $product->currency }} {{ number_format((float) $product->price, 2) }}</span>
                        <form method="POST" action="{{ route('storefront.cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="qty" value="1">
                            <x-primary-button>+</x-primary-button>
                        </form>
                    </div>
                </div>
            @empty
                <x-ui.empty-state title="No products yet" description="Add products from the admin dashboard to get started." />
            @endforelse
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-storefront-layout>
