<x-storefront-layout>
    <div class="max-w-xl mx-auto px-6 py-12">
        <x-ui.card title="Payment failed" description="We could not confirm payment for order #{{ $order->id }}.">
            <a class="inline-flex items-center text-sm font-medium text-accent-700 hover:text-accent-800" href="{{ route('storefront.checkout.show') }}">Try again</a>
        </x-ui.card>
    </div>
</x-storefront-layout>
