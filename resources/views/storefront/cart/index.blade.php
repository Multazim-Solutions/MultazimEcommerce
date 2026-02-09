<x-storefront-layout>
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 sm:py-10">
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-muted">Cart</p>
                <h1 class="font-display text-3xl text-ink-900">Your Cart</h1>
            </div>
            <a class="rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-ink-700 transition hover:border-sand-300 hover:text-ink-900 ui-ring" href="{{ route('storefront.products.index') }}">Continue shopping</a>
        </div>

        @if (session('status'))
            <x-ui.alert class="mb-4" variant="success" title="Updated">
                {{ session('status') }}
            </x-ui.alert>
        @endif

        @if ($errors->has('qty'))
            <x-ui.alert class="mb-4" variant="danger" title="Cart issue">
                @foreach ($errors->get('qty') as $message)
                    <div>{{ $message }}</div>
                @endforeach
            </x-ui.alert>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr,320px]">
            <section class="space-y-4">
                @forelse ($cart->items as $item)
                    @php
                        $product = $item->product;
                        $unitPrice = (float) ($product?->price ?? 0.0);
                        $lineTotal = $unitPrice * $item->qty;
                        $productName = $product?->name ?? 'Product unavailable';
                        $currencyCode = $product?->currency ?? $currency;
                    @endphp

                    <article class="rounded-2xl border border-sand-200 bg-white/90 p-4 shadow-elev-1">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <h2 class="text-base font-semibold text-ink-900">{{ $productName }}</h2>
                                <p class="mt-1 text-sm text-muted">
                                    Unit price: {{ $currencyCode }} {{ number_format($unitPrice, 2) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-xs uppercase tracking-[0.2em] text-muted">Line total</div>
                                <div class="text-base font-semibold text-ink-900">{{ $currencyCode }} {{ number_format($lineTotal, 2) }}</div>
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap items-end gap-3">
                            <form method="POST" action="{{ route('storefront.cart.update', $item) }}" class="flex flex-wrap items-end gap-2">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <x-input-label :for="'qty-'.$item->id" :value="__('Quantity')" />
                                    <x-text-input
                                        :id="'qty-'.$item->id"
                                        class="mt-1 w-24"
                                        type="number"
                                        min="1"
                                        name="qty"
                                        :value="(string) $item->qty"
                                        :max="$product !== null && $product->stock_qty > 0 ? (string) $product->stock_qty : null"
                                    />
                                </div>
                                <x-secondary-button>Update</x-secondary-button>
                            </form>

                            <form method="POST" action="{{ route('storefront.cart.remove', $item) }}">
                                @csrf
                                @method('DELETE')
                                <x-danger-button>Remove</x-danger-button>
                            </form>
                        </div>
                    </article>
                @empty
                    <x-ui.empty-state title="Your cart is empty" description="Browse the catalog and add items to continue." />
                @endforelse
            </section>

            <aside>
                <x-ui.card title="Order summary" description="Review totals before checkout.">
                    <dl class="space-y-3 text-sm">
                        <div class="flex items-center justify-between text-muted">
                            <dt>Subtotal</dt>
                            <dd>{{ $currency }} {{ number_format($totals->subtotal, 2) }}</dd>
                        </div>
                        <div class="flex items-center justify-between text-muted">
                            <dt>Shipping</dt>
                            <dd>{{ $currency }} {{ number_format($totals->shipping, 2) }}</dd>
                        </div>
                        <div class="flex items-center justify-between text-muted">
                            <dt>Tax</dt>
                            <dd>{{ $currency }} {{ number_format($totals->tax, 2) }}</dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-sand-200 pt-3 text-base font-semibold text-ink-900">
                            <dt>Total</dt>
                            <dd>{{ $currency }} {{ number_format($totals->total(), 2) }}</dd>
                        </div>
                    </dl>

                    <div class="mt-5">
                        @if ($cart->items->isEmpty())
                            <x-secondary-button type="button" class="w-full" disabled>Proceed to checkout</x-secondary-button>
                        @else
                            <a class="inline-flex w-full items-center justify-center rounded-xl bg-primary-700 px-4 py-2 text-sm font-semibold text-white shadow-elev-1 transition hover:bg-primary-800 ui-ring" href="{{ route('storefront.checkout.show') }}">
                                Proceed to checkout
                            </a>
                        @endif
                    </div>
                </x-ui.card>
            </aside>
        </div>
    </div>
</x-storefront-layout>
