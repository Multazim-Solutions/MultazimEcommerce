<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Order #{{ $order->id }}</h1>
        <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.orders.index') }}">Back</a>
    </div>

    <div class="rounded-lg border border-gray-200 p-4 mb-6">
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <div class="text-sm text-gray-500">Customer</div>
                <div class="text-sm text-gray-900">{{ $order->user?->name ?? 'Guest' }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Status</div>
                <div class="text-sm text-gray-900">{{ $order->status }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Total</div>
                <div class="text-sm text-gray-900">{{ $order->currency }} {{ number_format((float) $order->total, 2) }}</div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="mb-6 flex items-center gap-3">
        @csrf
        @method('PUT')
        <select name="status" class="rounded border-gray-300">
            @foreach (['pending', 'paid', 'failed', 'shipped', 'cancelled'] as $status)
                <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <x-secondary-button>Update status</x-secondary-button>
    </form>

    <div class="rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Item</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Qty</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Price</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Line total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($order->items as $item)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->name_snapshot }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $item->qty }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $order->currency }} {{ number_format((float) $item->price_snapshot, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $order->currency }} {{ number_format((float) $item->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
