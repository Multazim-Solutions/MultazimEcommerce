<x-guest-layout>
    <div class="max-w-5xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Products</h1>
            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('storefront.cart.index') }}">View cart</a>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($products as $product)
                <div class="rounded-lg border border-gray-200 p-4 shadow-sm">
                    <h2 class="text-lg font-medium text-gray-900">
                        <a href="{{ route('storefront.products.show', $product) }}">
                            {{ $product->name }}
                        </a>
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">{{ $product->description }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-900">{{ $product->currency }} {{ number_format((float) $product->price, 2) }}</span>
                        <form method="POST" action="{{ route('storefront.cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="qty" value="1">
                            <x-primary-button>+</x-primary-button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-gray-600">No products available.</div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-guest-layout>
