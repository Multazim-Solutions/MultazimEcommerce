<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(StoreProductImageRequest $request, Product $product): RedirectResponse
    {
        $path = $request->file('image')->store("products/{$product->id}", 'public');

        $product->images()->create([
            'path' => $path,
            'alt_text' => $request->input('alt_text'),
            'sort_order' => 0,
        ]);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Image uploaded');
    }

    public function destroy(Product $product, ProductImage $image): RedirectResponse
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Image removed');
    }
}
