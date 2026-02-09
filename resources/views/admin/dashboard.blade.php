<x-admin-layout title="Admin Dashboard">
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <x-ui.card title="Catalog" description="Product inventory health.">
            <dl class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <dt class="text-muted">Total products</dt>
                    <dd class="font-semibold text-ink-900">{{ $stats->totalProducts }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-muted">Active products</dt>
                    <dd class="font-semibold text-ink-900">{{ $stats->activeProducts }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-muted">Low stock (≤ 5)</dt>
                    <dd>
                        <x-ui.badge :variant="$stats->lowStockProducts > 0 ? 'warning' : 'success'">
                            {{ $stats->lowStockProducts }}
                        </x-ui.badge>
                    </dd>
                </div>
            </dl>
            <div class="mt-4">
                <a class="text-sm font-medium text-accent-700 hover:text-accent-800" href="{{ route('admin.products.index') }}">Manage products</a>
            </div>
        </x-ui.card>

        <x-ui.card title="Orders" description="Current fulfillment load.">
            <dl class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <dt class="text-muted">Pending</dt>
                    <dd>
                        <x-ui.badge :variant="$stats->pendingOrders > 0 ? 'warning' : 'neutral'">
                            {{ $stats->pendingOrders }}
                        </x-ui.badge>
                    </dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-muted">Paid</dt>
                    <dd>
                        <x-ui.badge variant="success">{{ $stats->paidOrders }}</x-ui.badge>
                    </dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-muted">Paid revenue</dt>
                    <dd class="font-semibold text-ink-900">BDT {{ number_format($stats->paidRevenue, 2) }}</dd>
                </div>
            </dl>
            <div class="mt-4">
                <a class="text-sm font-medium text-accent-700 hover:text-accent-800" href="{{ route('admin.orders.index') }}">Manage orders</a>
            </div>
        </x-ui.card>

        <x-ui.card title="Operations" description="Quick links for daily admin work.">
            <div class="space-y-2 text-sm">
                <a class="flex items-center justify-between rounded-lg border border-sand-200 bg-sand-100/60 px-3 py-2 transition hover:bg-sand-100" href="{{ route('admin.products.create') }}">
                    <span class="font-medium text-ink-900">Create product</span>
                    <span class="text-muted">New</span>
                </a>
                <a class="flex items-center justify-between rounded-lg border border-sand-200 bg-sand-100/60 px-3 py-2 transition hover:bg-sand-100" href="{{ route('admin.products.index', ['stock' => 'out_of_stock']) }}">
                    <span class="font-medium text-ink-900">Out of stock</span>
                    <span class="text-muted">Filter</span>
                </a>
                <a class="flex items-center justify-between rounded-lg border border-sand-200 bg-sand-100/60 px-3 py-2 transition hover:bg-sand-100" href="{{ route('admin.orders.index', ['status' => 'pending']) }}">
                    <span class="font-medium text-ink-900">Pending orders</span>
                    <span class="text-muted">Filter</span>
                </a>
            </div>
        </x-ui.card>
    </div>
</x-admin-layout>
