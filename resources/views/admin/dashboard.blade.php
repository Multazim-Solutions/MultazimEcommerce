<x-admin-layout title="Admin Dashboard">
    <div class="grid gap-6 sm:grid-cols-2">
        <a class="rounded-2xl border border-sand-200 bg-white/90 p-6 shadow-elev-1 transition hover:border-sand-300" href="{{ route('admin.products.index') }}">
            <div class="text-xs uppercase tracking-[0.3em] text-muted">Products</div>
            <div class="mt-3 font-display text-lg text-ink-900">Manage catalog</div>
            <div class="mt-1 text-sm text-muted">Pricing, inventory, and images.</div>
        </a>
        <a class="rounded-2xl border border-sand-200 bg-white/90 p-6 shadow-elev-1 transition hover:border-sand-300" href="{{ route('admin.orders.index') }}">
            <div class="text-xs uppercase tracking-[0.3em] text-muted">Orders</div>
            <div class="mt-3 font-display text-lg text-ink-900">Manage orders</div>
            <div class="mt-1 text-sm text-muted">Status updates and fulfillment.</div>
        </a>
    </div>
</x-admin-layout>
