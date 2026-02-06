<?php

declare(strict_types=1);

namespace App\Services\Images;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageStorageService
{
    public function storeProductOriginal(Product $product, UploadedFile $file): string
    {
        $path = $file->store((string) $product->id, 'products');

        $this->generateVariants($path);

        return $path;
    }

    public function deleteProductImage(ProductImage $image): void
    {
        $disk = Storage::disk('products');
        $disk->delete($image->path);

        foreach (['thumb', 'medium', 'large'] as $suffix) {
            $disk->delete($this->variantPath($image->path, $suffix));
        }
    }

    private function generateVariants(string $originalPath): void
    {
        $disk = Storage::disk('products');
        $absolute = $disk->path($originalPath);
        $manager = new ImageManager(new Driver());

        $variants = [
            'thumb' => ['method' => 'coverDown', 'width' => 200, 'height' => 200],
            'medium' => ['method' => 'scaleDown', 'width' => 800, 'height' => 800],
            'large' => ['method' => 'scaleDown', 'width' => 1200, 'height' => 1200],
        ];

        foreach ($variants as $suffix => $variant) {
            $image = $manager->read($absolute);
            $method = $variant['method'];
            $image->{$method}($variant['width'], $variant['height']);
            $image->save($disk->path($this->variantPath($originalPath, $suffix)));
        }
    }

    private function variantPath(string $originalPath, string $suffix): string
    {
        $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
        $filename = pathinfo($originalPath, PATHINFO_FILENAME);
        $directory = pathinfo($originalPath, PATHINFO_DIRNAME);

        return $directory.'/'.$filename.'_'.$suffix.'.'.$extension;
    }
}
