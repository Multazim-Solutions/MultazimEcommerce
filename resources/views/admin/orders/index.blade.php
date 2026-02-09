<x-admin-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-muted">Orders</p>
            <h1 class="font-display text-2xl text-ink-900">Orders</h1>
        </div>
    </div>

    <x-ui.card class="mb-5" title="Filter orders" description="Search by order id or customer and narrow by status.">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid gap-3 md:grid-cols-[1fr,220px,auto] md:items-end">
            <div>
                <x-input-label for="q" :value="__('Search')" />
                <x-text-input id="q" class="mt-1 w-full" name="q" type="search" :value="$filters['q']" placeholder="Order id, customer name, or email" />
            </div>
            <div>
                <x-input-label for="status" :value="__('Status')" />
                <x-select-input id="status" name="status" class="mt-1 w-full">
                    <option value="all" @selected($filters['status'] === 'all')>All statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected($filters['status'] === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </x-select-input>
            </div>
            <div class="flex gap-2 md:justify-end">
                <x-primary-button>Apply</x-primary-button>
                <a class="inline-flex items-center rounded-xl border border-sand-200 bg-white px-4 py-2 text-sm font-semibold text-ink-700 shadow-sm transition hover:bg-sand-100 ui-ring" href="{{ route('admin.orders.index') }}">Reset</a>
            </div>
        </form>
    </x-ui.card>

    @if ($orders->isEmpty())
        <x-ui.empty-state title="No orders found" description="Try changing search terms or status filter." />
    @else
        <x-ui.table>
            <thead class="bg-sand-100 text-xs uppercase tracking-widest text-muted">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">Order</th>
                    <th class="px-4 py-3 text-left font-medium">Customer</th>
                    <th class="px-4 py-3 text-left font-medium">Total</th>
                    <th class="px-4 py-3 text-left font-medium">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-200">
                @foreach ($orders as $order)
                    <tr class="hover:bg-sand-50/70">
                        <td class="px-4 py-3 text-sm font-medium text-ink-900">#{{ $order->id }}</td>
                        <td class="px-4 py-3 text-sm text-muted">{{ $order->user?->name ?? 'Guest' }}</td>
                        <td class="px-4 py-3 text-sm text-muted">{{ $order->currency }} {{ number_format((float) $order->total, 2) }}</td>
                        <td class="px-4 py-3 text-sm">
                            <x-ui.badge :variant="$order->status->badgeVariant()">{{ $order->status->label() }}</x-ui.badge>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a class="text-sm font-medium text-accent-700 hover:text-accent-800" href="{{ route('admin.orders.show', $order) }}">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-ui.table>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</x-admin-layout>
