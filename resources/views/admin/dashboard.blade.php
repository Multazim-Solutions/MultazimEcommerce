<x-admin-layout title="Admin Dashboard">
    <div class="grid gap-6 sm:grid-cols-2">
        <a class="rounded-lg border border-gray-200 p-6 hover:border-gray-300" href="{{ route('admin.products.index') }}">
            <div class="text-sm text-gray-500">Products</div>
            <div class="mt-2 text-lg font-semibold text-gray-900">Manage catalog</div>
        </a>
        <a class="rounded-lg border border-gray-200 p-6 hover:border-gray-300" href="{{ route('admin.orders.index') }}">
            <div class="text-sm text-gray-500">Orders</div>
            <div class="mt-2 text-lg font-semibold text-gray-900">Manage orders</div>
        </a>
    </div>
</x-admin-layout>
