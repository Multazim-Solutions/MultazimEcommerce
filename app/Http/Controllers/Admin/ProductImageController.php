<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\Images\ImageStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(StoreProductImageRequest $request, Product $product, ImageStorageService $storage): RedirectResponse
    {
        $path = $storage->storeProductOriginal($product, $request->file('image'));

        $product->images()->create([
            'path' => $path,
            'alt_text' => null,
            'sort_order' => 0,
        ]);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Image uploaded');
    }

    public function destroy(Product $product, ProductImage $image, ImageStorageService $storage): RedirectResponse
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }

        Storage::disk('products')->delete($image->path);
        $image->delete();

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Image removed');
    }
}
