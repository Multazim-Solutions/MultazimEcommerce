<x-admin-layout>
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-muted">Catalog</p>
            <h1 class="font-display text-2xl text-ink-900">Edit Product</h1>
        </div>
        <a class="rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-ink-700 transition hover:border-sand-300 hover:text-ink-900" href="{{ route('admin.products.index') }}">Back</a>
    </div>

    <x-ui.card>
        <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-4">
            @csrf
            @method('PUT')

            @include('admin.products.partials.form', ['product' => $product])

            <div class="flex justify-end">
                <x-primary-button>Save</x-primary-button>
            </div>
        </form>
    </x-ui.card>

    <x-ui.card class="mt-8" title="Images" description="Upload product shots and manage the gallery.">
        <form method="POST" action="{{ route('admin.products.images.store', $product) }}" enctype="multipart/form-data" class="flex flex-wrap items-center gap-3">
            @csrf
            <input class="text-sm text-muted" type="file" name="image" required>
            <x-text-input class="min-w-[180px]" type="text" name="alt_text" placeholder="Alt text" />
            <x-secondary-button>Upload</x-secondary-button>
        </form>

        <div class="mt-4 grid gap-3 sm:grid-cols-3">
            @forelse ($product->images as $image)
                <div class="rounded-xl border border-sand-200 bg-white p-2 shadow-sm">
                    <img class="h-32 w-full rounded-lg object-cover" src="{{ \Illuminate\Support\Facades\Storage::disk('products')->url($image->path) }}" alt="{{ $image->alt_text }}">
                    <form method="POST" action="{{ route('admin.products.images.destroy', [$product, $image]) }}" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <x-danger-button>Remove</x-danger-button>
                    </form>
                </div>
            @empty
                <x-ui.empty-state title="No images yet" description="Upload a primary image to start the gallery." />
            @endforelse
        </div>
    </x-ui.card>

    <form class="mt-8" method="POST" action="{{ route('admin.products.destroy', $product) }}">
        @csrf
        @method('DELETE')
        <x-danger-button>Delete product</x-danger-button>
    </form>
</x-admin-layout>
