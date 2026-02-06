<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">New Product</h1>
        <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.products.index') }}">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-4">
        @csrf

        @include('admin.products.partials.form', ['product' => null])

        <div class="flex justify-end">
            <x-primary-button>Create</x-primary-button>
        </div>
    </form>
</x-admin-layout>
