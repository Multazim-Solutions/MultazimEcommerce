<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Products</h1>
        <a class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white" href="{{ route('admin.products.create') }}">New product</a>
    </div>

    <div class="rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Price</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Stock</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($products as $product)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $product->currency }} {{ number_format((float) $product->price, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $product->stock_qty }}</td>
                        <td class="px-4 py-3 text-right">
                            <a class="text-sm text-indigo-600 hover:text-indigo-900" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-admin-layout>
