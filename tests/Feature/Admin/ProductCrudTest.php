<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\Category;
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

        $category = Category::factory()->subcategory()->create();

        $payload = [
            'category_id' => $category->id,
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

        $updatedCategory = Category::factory()->subcategory()->create();

        $update = [
            'category_id' => $updatedCategory->id,
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

    public function test_admin_can_filter_products_by_status_and_stock(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        Product::factory()->create([
            'name' => 'Visible Product',
            'is_active' => true,
            'stock_qty' => 5,
        ]);

        Product::factory()->create([
            'name' => 'Archived Product',
            'is_active' => false,
            'stock_qty' => 0,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.products.index', [
                'active' => 'inactive',
                'stock' => 'out_of_stock',
            ]))
            ->assertOk()
            ->assertSee('Archived Product')
            ->assertDontSee('Visible Product');
    }
}
