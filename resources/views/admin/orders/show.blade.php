<x-admin-layout>
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-muted">Order</p>
            <h1 class="font-display text-2xl text-ink-900">Order #{{ $order->id }}</h1>
        </div>
        <a class="rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-ink-700 transition hover:border-sand-300 hover:text-ink-900" href="{{ route('admin.orders.index') }}">Back</a>
    </div>

    <x-ui.card class="mb-6" title="Order summary">
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <div class="text-xs uppercase tracking-[0.2em] text-muted">Customer</div>
                <div class="text-sm font-medium text-ink-900">{{ $order->user?->name ?? 'Guest' }}</div>
            </div>
            <div>
                <div class="text-xs uppercase tracking-[0.2em] text-muted">Status</div>
                <div class="text-sm font-medium text-ink-900">{{ $order->status }}</div>
            </div>
            <div>
                <div class="text-xs uppercase tracking-[0.2em] text-muted">Total</div>
                <div class="text-sm font-medium text-ink-900">{{ $order->currency }} {{ number_format((float) $order->total, 2) }}</div>
            </div>
        </div>
    </x-ui.card>

    <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="mb-6 flex flex-wrap items-center gap-3">
        @csrf
        @method('PUT')
        <x-select-input name="status" class="min-w-[180px]">
            @foreach (['pending', 'paid', 'failed', 'shipped', 'cancelled'] as $status)
                <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </x-select-input>
        <x-secondary-button>Update status</x-secondary-button>
    </form>

    <x-ui.table>
        <thead class="bg-sand-100 text-xs uppercase tracking-widest text-muted">
            <tr>
                <th class="px-4 py-3 text-left font-medium">Item</th>
                <th class="px-4 py-3 text-left font-medium">Qty</th>
                <th class="px-4 py-3 text-left font-medium">Price</th>
                <th class="px-4 py-3 text-left font-medium">Line total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-sand-200">
            @foreach ($order->items as $item)
                <tr class="hover:bg-sand-50/70">
                    <td class="px-4 py-3 text-sm font-medium text-ink-900">{{ $item->name_snapshot }}</td>
                    <td class="px-4 py-3 text-sm text-muted">{{ $item->qty }}</td>
                    <td class="px-4 py-3 text-sm text-muted">{{ $order->currency }} {{ number_format((float) $item->price_snapshot, 2) }}</td>
                    <td class="px-4 py-3 text-sm text-muted">{{ $order->currency }} {{ number_format((float) $item->line_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </x-ui.table>
</x-admin-layout>
