<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_products(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $payload = [
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Simple description',
            'price' => 199.99,
            'currency' => 'BDT',
            'stock_qty' => 10,
            'is_active' => true,
        ];

        $this->actingAs($admin)
            ->post(route('admin.products.store'), $payload)
            ->assertRedirect();

        $product = Product::query()->where('slug', 'test-product')->firstOrFail();

        $update = [
            'name' => 'Updated Product',
            'slug' => 'updated-product',
            'description' => 'Updated description',
            'price' => 299.99,
            'currency' => 'BDT',
            'stock_qty' => 20,
            'is_active' => false,
        ];

        $this->actingAs($admin)
            ->put(route('admin.products.update', $product), $update)
            ->assertRedirect();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'slug' => 'updated-product',
            'is_active' => false,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
