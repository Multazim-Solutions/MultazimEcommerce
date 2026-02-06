<x-guest-layout>
    <div class="max-w-xl mx-auto px-6 py-12">
        <h1 class="text-2xl font-semibold text-gray-900">Payment cancelled</h1>
        <p class="mt-2 text-gray-600">Payment was cancelled for order #{{ $order->id }}.</p>
        <a class="mt-6 inline-flex items-center text-sm text-gray-700 hover:text-gray-900" href="{{ route('storefront.checkout.show') }}">Return to checkout</a>
    </div>
</x-guest-layout>
