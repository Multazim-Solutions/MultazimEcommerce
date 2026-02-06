<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Orders</h1>
    </div>

    <div class="rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Order</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Total</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($orders as $order)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">#{{ $order->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $order->user?->name ?? 'Guest' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $order->currency }} {{ number_format((float) $order->total, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $order->status }}</td>
                        <td class="px-4 py-3 text-right">
                            <a class="text-sm text-indigo-600 hover:text-indigo-900" href="{{ route('admin.orders.show', $order) }}">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</x-admin-layout>
