<x-guest-layout>
    <div class="max-w-4xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-6">
            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('storefront.products.index') }}">Back to products</a>
            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('storefront.cart.index') }}">View cart</a>
        </div>

        <div class="rounded-lg border border-gray-200 p-6">
            <h1 class="text-2xl font-semibold text-gray-900">{{ $product->name }}</h1>
            <p class="mt-3 text-gray-600">{{ $product->description }}</p>
            <div class="mt-4 text-lg font-semibold text-gray-900">
                {{ $product->currency }} {{ number_format((float) $product->price, 2) }}
            </div>

            <form class="mt-6 flex items-center gap-3" method="POST" action="{{ route('storefront.cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input class="w-20 rounded border-gray-300" type="number" min="1" name="qty" value="1">
                <x-primary-button>Add to cart</x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
