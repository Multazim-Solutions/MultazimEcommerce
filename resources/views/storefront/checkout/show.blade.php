<x-storefront-layout>
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 sm:py-10">
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-muted">Checkout</p>
                <h1 class="font-display text-3xl text-ink-900">Checkout</h1>
            </div>
            <a class="rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-ink-700 transition hover:border-sand-300 hover:text-ink-900 ui-ring" href="{{ route('storefront.cart.index') }}">Back to cart</a>
        </div>

        @if (session('status'))
            <x-ui.alert class="mb-4" variant="success" title="Updated">
                {{ session('status') }}
            </x-ui.alert>
        @endif

        @if ($errors->has('cart') || $errors->has('payment'))
            <x-ui.alert class="mb-4" variant="danger" title="Checkout issue">
                @foreach (['cart', 'payment'] as $key)
                    @foreach ($errors->get($key) as $message)
                        <div>{{ $message }}</div>
                    @endforeach
                @endforeach
            </x-ui.alert>
        @endif

        @if ($cart->items->isEmpty())
            <x-ui.empty-state title="Your cart is empty" description="Add products before starting checkout." />
            <div class="mt-4">
                <a class="inline-flex items-center rounded-xl bg-accent-600 px-4 py-2 text-sm font-semibold text-white shadow-elev-1 transition hover:bg-accent-700 ui-ring" href="{{ route('storefront.products.index') }}">
                    Browse products
                </a>
            </div>
        @else
            <div class="grid gap-6 lg:grid-cols-[1fr,320px]">
                <x-ui.card title="Delivery details" description="Contact and shipping details for this order.">
                    <form method="POST" action="{{ route('storefront.checkout.store') }}" class="space-y-5" x-data="{ submitting: false }" x-on:submit="submitting = true">
                        @csrf

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <x-input-label for="full_name" :value="__('Full name')" />
                                <x-text-input id="full_name" class="mt-1 block w-full" type="text" name="full_name" :value="old('full_name')" required autocomplete="name" />
                                <p class="mt-1 text-xs text-muted">Use the recipient's legal name.</p>
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Phone')" />
                                <x-text-input id="phone" class="mt-1 block w-full" type="text" name="phone" :value="old('phone')" required autocomplete="tel" />
                                <p class="mt-1 text-xs text-muted">We only use this for delivery updates.</p>
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="address_line1" :value="__('Address line 1')" />
                            <x-text-input id="address_line1" class="mt-1 block w-full" type="text" name="address_line1" :value="old('address_line1')" required autocomplete="address-line1" />
                            <x-input-error :messages="$errors->get('address_line1')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="address_line2" :value="__('Address line 2 (optional)')" />
                            <x-text-input id="address_line2" class="mt-1 block w-full" type="text" name="address_line2" :value="old('address_line2')" autocomplete="address-line2" />
                            <x-input-error :messages="$errors->get('address_line2')" class="mt-2" />
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" class="mt-1 block w-full" type="text" name="city" :value="old('city')" required autocomplete="address-level2" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="postal_code" :value="__('Postal code')" />
                                <x-text-input id="postal_code" class="mt-1 block w-full" type="text" name="postal_code" :value="old('postal_code')" required autocomplete="postal-code" />
                                <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                            </div>
                        </div>

                        <fieldset class="rounded-xl border border-sand-200 bg-sand-100/60 p-4">
                            <legend class="px-1 text-sm font-semibold text-ink-900">Payment method</legend>
                            <label class="mt-2 flex cursor-pointer items-start gap-3 rounded-lg border border-sand-200 bg-white p-3">
                                <input
                                    class="mt-1 rounded border-sand-300 text-accent-600 focus:ring-accent-500"
                                    type="radio"
                                    name="payment_method"
                                    value="sslcommerz"
                                    @checked(old('payment_method', 'sslcommerz') === 'sslcommerz')
                                >
                                <span>
                                    <span class="block text-sm font-medium text-ink-900">SSLCommerz</span>
                                    <span class="block text-xs text-muted">Secure card, mobile banking, and wallet payment gateway.</span>
                                </span>
                            </label>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </fieldset>

                        <div class="flex justify-end">
                            <x-primary-button x-bind:disabled="submitting">
                                <span x-show="!submitting">Continue to payment</span>
                                <span x-show="submitting" x-cloak>Starting payment...</span>
                            </x-primary-button>
                        </div>
                        <x-ui.loading x-show="submitting" x-cloak label="Preparing payment..." />
                    </form>
                </x-ui.card>

                <aside>
                    <x-ui.card title="Order summary" description="Review totals before payment.">
                        <div class="space-y-3 text-sm">
                            @foreach ($cart->items as $item)
                                @php
                                    $itemProduct = $item->product;
                                    $itemCurrency = $itemProduct?->currency ?? $currency;
                                    $itemTotal = (float) ($itemProduct?->price ?? 0.0) * $item->qty;
                                @endphp
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-medium text-ink-900">{{ $itemProduct?->name ?? 'Item removed' }}</p>
                                        <p class="text-xs text-muted">Qty {{ $item->qty }}</p>
                                    </div>
                                    <p class="font-medium text-ink-900">{{ $itemCurrency }} {{ number_format($itemTotal, 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <dl class="mt-4 space-y-3 border-t border-sand-200 pt-4 text-sm">
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
                            <div class="flex items-center justify-between text-base font-semibold text-ink-900">
                                <dt>Total</dt>
                                <dd>{{ $currency }} {{ number_format($totals->total(), 2) }}</dd>
                            </div>
                        </dl>
                    </x-ui.card>
                </aside>
            </div>
        @endif
    </div>
</x-storefront-layout>
