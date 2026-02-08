<x-admin-layout>
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-muted">Catalog</p>
            <h1 class="font-display text-2xl text-ink-900">New Product</h1>
        </div>
        <a class="rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-ink-700 transition hover:border-sand-300 hover:text-ink-900" href="{{ route('admin.products.index') }}">Back</a>
    </div>

    <x-ui.card>
        <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-4">
            @csrf

            @include('admin.products.partials.form', ['product' => null])

            <div class="flex justify-end">
                <x-primary-button>Create</x-primary-button>
            </div>
        </form>
    </x-ui.card>
</x-admin-layout>
