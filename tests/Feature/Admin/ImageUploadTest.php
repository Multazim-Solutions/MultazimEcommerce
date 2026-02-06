<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_product_images(): void
    {
        Storage::fake('products');

        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $product = Product::factory()->create();

        $file = UploadedFile::fake()->image('product.jpg', 600, 600);

        $this->actingAs($admin)
            ->post(route('admin.products.images.store', $product), [
                'image' => $file,
                'alt_text' => 'Sample image',
            ])
            ->assertRedirect(route('admin.products.edit', $product));

        $image = ProductImage::query()->firstOrFail();

        Storage::disk('products')->assertExists($image->path);
        $this->assertSame($product->id, $image->product_id);
    }
}
