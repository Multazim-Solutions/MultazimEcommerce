<x-admin-layout>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-muted">Catalog</p>
            <h1 class="font-display text-2xl text-ink-900">Edit Product</h1>
        </div>
        <a class="rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-ink-700 transition hover:border-sand-300 hover:text-ink-900" href="{{ route('admin.products.index') }}">Back</a>
    </div>

    <x-ui.card>
        <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-4" x-data="{ submitting: false }" x-on:submit="submitting = true">
            @csrf
            @method('PUT')

            @include('admin.products.partials.form', ['product' => $product, 'categoryGroups' => $categoryGroups])

            <div class="flex justify-end">
                <x-primary-button x-bind:disabled="submitting">
                    <span x-show="!submitting">Save</span>
                    <span x-show="submitting" x-cloak>Saving...</span>
                </x-primary-button>
            </div>
            <x-ui.loading x-show="submitting" x-cloak label="Saving product..." />
        </form>
    </x-ui.card>

    <x-ui.card class="mt-8" title="Images" description="Upload product shots and manage the gallery.">
        <form
            method="POST"
            action="{{ route('admin.products.images.store', $product) }}"
            enctype="multipart/form-data"
            class="space-y-4"
            x-data="{ previewUrl: null, uploading: false }"
            x-on:submit="uploading = true"
        >
            @csrf

            <div class="grid gap-4 md:grid-cols-[1fr,220px,auto] md:items-end">
                <div>
                    <x-input-label for="image" :value="__('Image file')" />
                    <input
                        id="image"
                        class="mt-1 block w-full rounded-xl border border-sand-200 bg-white px-3 py-2 text-sm text-ink-900 file:mr-3 file:rounded-lg file:border-0 file:bg-sand-100 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-ink-700 focus:border-accent-500 focus:ring-accent-500 ui-ring"
                        type="file"
                        name="image"
                        accept="image/png,image/jpeg,image/webp"
                        required
                        x-on:change="const file = $event.target.files?.[0]; previewUrl = file ? URL.createObjectURL(file) : null"
                    >
                    <p class="mt-1 text-xs text-muted">JPG, PNG, or WebP. Max size 2 MB.</p>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="alt_text" :value="__('Alt text')" />
                    <x-text-input id="alt_text" class="mt-1 w-full" type="text" name="alt_text" :value="old('alt_text')" placeholder="Describe the image" />
                    <x-input-error :messages="$errors->get('alt_text')" class="mt-2" />
                </div>

                <div>
                    <x-secondary-button class="w-full md:w-auto" x-bind:disabled="uploading">
                        <span x-show="!uploading">Upload</span>
                        <span x-show="uploading" x-cloak>Uploading...</span>
                    </x-secondary-button>
                </div>
            </div>

            <div x-show="previewUrl" x-cloak class="rounded-xl border border-sand-200 bg-sand-100/50 p-3">
                <p class="mb-2 text-xs font-medium uppercase tracking-[0.2em] text-muted">Preview</p>
                <img x-bind:src="previewUrl" alt="Selected file preview" class="h-40 w-full rounded-lg object-cover sm:w-56">
            </div>
            <x-ui.loading x-show="uploading" x-cloak label="Uploading image..." />
        </form>

        <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($product->images as $image)
                <article class="rounded-xl border border-sand-200 bg-white p-2 shadow-sm">
                    <img class="h-32 w-full rounded-lg object-cover" src="{{ \Illuminate\Support\Facades\Storage::disk('products')->url($image->path) }}" alt="{{ $image->alt_text ?? $product->name }}" loading="lazy" decoding="async">
                    <div class="mt-2 flex items-center justify-between gap-2">
                        <p class="truncate text-xs text-muted">{{ $image->alt_text ?? 'No alt text' }}</p>
                        <form method="POST" action="{{ route('admin.products.images.destroy', [$product, $image]) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Remove</x-danger-button>
                        </form>
                    </div>
                </article>
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
