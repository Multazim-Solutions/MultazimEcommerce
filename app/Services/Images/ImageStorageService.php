<?php

declare(strict_types=1);

namespace App\Services\Images;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageStorageService
{
    public function storeProductOriginal(Product $product, UploadedFile $file): string
    {
        return $file->store((string) $product->id, 'products');
    }
}
