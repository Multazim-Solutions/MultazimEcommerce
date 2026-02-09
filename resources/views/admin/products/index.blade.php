<x-admin-layout>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-muted">Catalog</p>
            <h1 class="font-display text-2xl text-ink-900">Products</h1>
        </div>
        <a class="inline-flex items-center rounded-xl bg-accent-600 px-4 py-2 text-sm font-semibold text-white shadow-elev-1 transition hover:bg-accent-700 ui-ring" href="{{ route('admin.products.create') }}">New product</a>
    </div>

    <x-ui.card class="mb-5" title="Filter products" description="Search by name/slug, filter by stock and status.">
        <form method="GET" action="{{ route('admin.products.index') }}" class="grid gap-3 md:grid-cols-[1fr,170px,170px,190px,auto] md:items-end">
            <div>
                <x-input-label for="q" :value="__('Search')" />
                <x-text-input id="q" class="mt-1 w-full" name="q" type="search" :value="$filters['q']" placeholder="Name or slug" />
            </div>

            <div>
                <x-input-label for="stock" :value="__('Stock')" />
                <x-select-input id="stock" name="stock" class="mt-1 w-full">
                    <option value="all" @selected($filters['stock'] === 'all')>All stock</option>
                    <option value="in_stock" @selected($filters['stock'] === 'in_stock')>In stock</option>
                    <option value="out_of_stock" @selected($filters['stock'] === 'out_of_stock')>Out of stock</option>
                </x-select-input>
            </div>

            <div>
                <x-input-label for="active" :value="__('Status')" />
                <x-select-input id="active" name="active" class="mt-1 w-full">
                    <option value="all" @selected($filters['active'] === 'all')>All statuses</option>
                    <option value="active" @selected($filters['active'] === 'active')>Active</option>
                    <option value="inactive" @selected($filters['active'] === 'inactive')>Inactive</option>
                </x-select-input>
            </div>

            <div>
                <x-input-label for="sort" :value="__('Sort')" />
                <x-select-input id="sort" name="sort" class="mt-1 w-full">
                    <option value="newest" @selected($filters['sort'] === 'newest')>Newest first</option>
                    <option value="name_asc" @selected($filters['sort'] === 'name_asc')>Name A-Z</option>
                    <option value="price_desc" @selected($filters['sort'] === 'price_desc')>Price high-low</option>
                    <option value="stock_low" @selected($filters['sort'] === 'stock_low')>Lowest stock first</option>
                </x-select-input>
            </div>

            <div class="flex gap-2 md:justify-end">
                <x-primary-button>Apply</x-primary-button>
                <a class="inline-flex items-center rounded-xl border border-sand-200 bg-white px-4 py-2 text-sm font-semibold text-ink-700 shadow-sm transition hover:bg-sand-100 ui-ring" href="{{ route('admin.products.index') }}">Reset</a>
            </div>
        </form>
    </x-ui.card>

    @if ($products->isEmpty())
        <x-ui.empty-state title="No products found" description="Try different filters or create a new product." />
        <div class="mt-4">
            <a class="inline-flex items-center rounded-xl bg-accent-600 px-4 py-2 text-sm font-semibold text-white shadow-elev-1 transition hover:bg-accent-700 ui-ring" href="{{ route('admin.products.create') }}">
                Create product
            </a>
        </div>
    @else
        <x-ui.table>
            <thead class="bg-sand-100 text-xs uppercase tracking-widest text-muted">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">Name</th>
                    <th class="px-4 py-3 text-left font-medium">Price</th>
                    <th class="px-4 py-3 text-left font-medium">Stock</th>
                    <th class="px-4 py-3 text-left font-medium">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-200">
                @foreach ($products as $product)
                    <tr class="hover:bg-sand-50/70">
                        <td class="px-4 py-3 text-sm font-medium text-ink-900">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-sm text-muted">{{ $product->currency }} {{ number_format((float) $product->price, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-muted">{{ $product->stock_qty }}</td>
                        <td class="px-4 py-3 text-sm">
                            <x-ui.badge :variant="$product->is_active ? 'success' : 'neutral'">{{ $product->is_active ? 'Active' : 'Inactive' }}</x-ui.badge>
                        </td>
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
    @endif
</x-admin-layout>
