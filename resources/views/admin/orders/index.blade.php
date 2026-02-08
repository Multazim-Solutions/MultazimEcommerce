<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-muted">Orders</p>
            <h1 class="font-display text-2xl text-ink-900">Orders</h1>
        </div>
    </div>

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
                @php
                    $statusVariant = match ($order->status) {
                        'paid' => 'success',
                        'failed' => 'danger',
                        'cancelled' => 'warning',
                        default => 'neutral',
                    };
                @endphp
                <tr class="hover:bg-sand-50/70">
                    <td class="px-4 py-3 text-sm font-medium text-ink-900">#{{ $order->id }}</td>
                    <td class="px-4 py-3 text-sm text-muted">{{ $order->user?->name ?? 'Guest' }}</td>
                    <td class="px-4 py-3 text-sm text-muted">{{ $order->currency }} {{ number_format((float) $order->total, 2) }}</td>
                    <td class="px-4 py-3 text-sm">
                        <x-ui.badge :variant="$statusVariant">{{ $order->status }}</x-ui.badge>
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
</x-admin-layout>
