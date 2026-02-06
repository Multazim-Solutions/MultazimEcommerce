<x-guest-layout>
    <div class="max-w-4xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Your Cart</h1>
            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('storefront.products.index') }}">Continue shopping</a>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse ($cart->items as $item)
                <div class="rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-medium text-gray-900">{{ $item->product?->name ?? 'Product' }}</div>
                            <div class="text-sm text-gray-600">Qty: {{ $item->qty }}</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <form method="POST" action="{{ route('storefront.cart.update', $item) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input class="w-20 rounded border-gray-300" type="number" min="1" name="qty" value="{{ $item->qty }}">
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
                <div class="text-gray-600">Your cart is empty.</div>
            @endforelse
        </div>

        <div class="mt-6 flex justify-end">
            <a class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white" href="{{ route('storefront.checkout.show') }}">
                Proceed to checkout
            </a>
        </div>
    </div>
</x-guest-layout>
