<x-storefront-layout>
    <div class="max-w-5xl mx-auto px-6 py-10">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-muted">Cart</p>
                <h1 class="font-display text-3xl text-ink-900">Your Cart</h1>
            </div>
            <a class="rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-ink-700 transition hover:border-sand-300 hover:text-ink-900" href="{{ route('storefront.products.index') }}">Continue shopping</a>
        </div>

        @if (session('status'))
            <x-ui.alert class="mb-4" variant="success" title="Updated">
                {{ session('status') }}
            </x-ui.alert>
        @endif

        <div class="space-y-4">
            @forelse ($cart->items as $item)
                <div class="rounded-2xl border border-sand-200 bg-white/90 p-4 shadow-elev-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-ink-900">{{ $item->product?->name ?? 'Product' }}</div>
                            <div class="text-sm text-muted">Qty: {{ $item->qty }}</div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <form method="POST" action="{{ route('storefront.cart.update', $item) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <x-text-input class="w-20" type="number" min="1" name="qty" value="{{ $item->qty }}" />
                                <x-secondary-button>Update</x-secondary-button>
                            </form>
                            <form method="POST" action="{{ route('storefront.cart.remove', $item) }}">
                                @csrf
                                @method('DELETE')
                                <x-danger-button>Remove</x-danger-button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <x-ui.empty-state title="Your cart is empty" description="Browse the catalog and add items to continue." />
            @endforelse
        </div>

        <div class="mt-6 flex justify-end">
            <a class="inline-flex items-center rounded-xl bg-accent-600 px-4 py-2 text-sm font-semibold text-white shadow-elev-1 transition hover:bg-accent-700 ui-ring" href="{{ route('storefront.checkout.show') }}">
                Proceed to checkout
            </a>
        </div>
    </div>
</x-storefront-layout>
