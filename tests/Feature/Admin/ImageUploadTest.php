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

    public function test_admin_image_upload_validates_file_type(): void
    {
        Storage::fake('products');

        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $product = Product::factory()->create();

        $this->actingAs($admin)
            ->from(route('admin.products.edit', $product))
            ->post(route('admin.products.images.store', $product), [
                'image' => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
                'alt_text' => 'Should fail',
            ])
            ->assertRedirect(route('admin.products.edit', $product))
            ->assertSessionHasErrors(['image']);
    }
}
