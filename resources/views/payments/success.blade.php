<x-guest-layout>
    <div class="max-w-xl mx-auto px-6 py-12">
        <h1 class="text-2xl font-semibold text-gray-900">Payment successful</h1>
        <p class="mt-2 text-gray-600">Order #{{ $order->id }} has been paid.</p>
        <a class="mt-6 inline-flex items-center text-sm text-gray-700 hover:text-gray-900" href="{{ route('storefront.products.index') }}">Back to storefront</a>
    </div>
</x-guest-layout>
