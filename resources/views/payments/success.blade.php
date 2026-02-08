<x-storefront-layout>
    <div class="max-w-xl mx-auto px-6 py-12">
        <x-ui.card title="Payment successful" description="Order #{{ $order->id }} has been paid.">
            <a class="inline-flex items-center text-sm font-medium text-accent-700 hover:text-accent-800" href="{{ route('storefront.products.index') }}">Back to storefront</a>
        </x-ui.card>
    </div>
</x-storefront-layout>
