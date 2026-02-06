<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Product</h1>
        <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.products.index') }}">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-4">
        @csrf
        @method('PUT')

        @include('admin.products.partials.form', ['product' => $product])

        <div class="flex justify-end">
            <x-primary-button>Save</x-primary-button>
        </div>
    </form>

    <div class="mt-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Images</h2>

        <form method="POST" action="{{ route('admin.products.images.store', $product) }}" enctype="multipart/form-data" class="flex items-center gap-3">
            @csrf
            <input type="file" name="image" required>
            <input class="rounded border-gray-300" type="text" name="alt_text" placeholder="Alt text">
            <x-secondary-button>Upload</x-secondary-button>
        </form>

        <div class="mt-4 grid gap-3 sm:grid-cols-3">
            @foreach ($product->images as $image)
                <div class="rounded border border-gray-200 p-2">
                    <img class="w-full h-32 object-cover" src="{{ \Illuminate\Support\Facades\Storage::disk('products')->url($image->path) }}" alt="{{ $image->alt_text }}">
                    <form method="POST" action="{{ route('admin.products.images.destroy', [$product, $image]) }}" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <x-danger-button>Remove</x-danger-button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <form class="mt-8" method="POST" action="{{ route('admin.products.destroy', $product) }}">
        @csrf
        @method('DELETE')
        <x-danger-button>Delete product</x-danger-button>
    </form>
</x-admin-layout>
