<x-admin-layout>
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-muted">Catalog</p>
            <h1 class="font-display text-2xl text-ink-900">Products</h1>
        </div>
        <a class="inline-flex items-center rounded-xl bg-accent-600 px-4 py-2 text-sm font-semibold text-white shadow-elev-1 transition hover:bg-accent-700 ui-ring" href="{{ route('admin.products.create') }}">New product</a>
    </div>

    <x-ui.table>
        <thead class="bg-sand-100 text-xs uppercase tracking-widest text-muted">
            <tr>
                <th class="px-4 py-3 text-left font-medium">Name</th>
                <th class="px-4 py-3 text-left font-medium">Price</th>
                <th class="px-4 py-3 text-left font-medium">Stock</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-sand-200">
            @foreach ($products as $product)
                <tr class="hover:bg-sand-50/70">
                    <td class="px-4 py-3 text-sm font-medium text-ink-900">{{ $product->name }}</td>
                    <td class="px-4 py-3 text-sm text-muted">{{ $product->currency }} {{ number_format((float) $product->price, 2) }}</td>
                    <td class="px-4 py-3 text-sm text-muted">{{ $product->stock_qty }}</td>
                    <td class="px-4 py-3 text-right">
                        <a class="text-sm font-medium text-accent-700 hover:text-accent-800" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </x-ui.table>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-admin-layout>
