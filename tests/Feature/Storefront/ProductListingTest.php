<?php

declare(strict_types=1);

namespace Tests\Feature\Storefront;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_storefront_list_shows_active_products(): void
    {
        Product::factory()->create([
            'name' => 'Active Product',
            'is_active' => true,
        ]);

        Product::factory()->create([
            'name' => 'Hidden Product',
            'is_active' => false,
        ]);

        $this->get(route('storefront.products.index'))
            ->assertOk()
            ->assertSee('Active Product')
            ->assertDontSee('Hidden Product');

        $this->get(route('storefront.home'))
            ->assertOk()
            ->assertSee('Search')
            ->assertSee('Call: 01317448899')
            ->assertSee('Sign in')
            ->assertDontSee('Admin sign-in')
            ->assertSee('Mobile Accessories')
            ->assertSee('Chargers')
            ->assertSee('Promotional Banner')
            ->assertSee('c47UZMJLOFSZPAp3c6ZuzDL8omp0r8NKA7oOhNoB.png')
            ->assertSee('Categories')
            ->assertSee(route('storefront.categories.index'))
            ->assertSee('Flash Sale Products')
            ->assertSee('Hot Selling Products')
            ->assertSee('New Arrival Products')
            ->assertSee('Top Selling Products')
            ->assertSee('Active Product')
            ->assertDontSee('Hidden Product');
    }

    public function test_storefront_product_detail_shows_product(): void
    {
        $product = Product::factory()->create([
            'name' => 'Detail Product',
            'is_active' => true,
        ]);

        $this->get(route('storefront.products.show', $product))
            ->assertOk()
            ->assertSee('Detail Product');
    }

    public function test_storefront_product_detail_hides_inactive_products(): void
    {
        $product = Product::factory()->create([
            'is_active' => false,
        ]);

        $this->get(route('storefront.products.show', $product))
            ->assertNotFound();
    }

    public function test_storefront_list_applies_stock_and_search_filters(): void
    {
        Product::factory()->create([
            'name' => 'Atlas Boots',
            'description' => 'Premium leather pair',
            'stock_qty' => 8,
            'is_active' => true,
        ]);

        Product::factory()->create([
            'name' => 'Atlas Jacket',
            'description' => 'Winter outerwear',
            'stock_qty' => 0,
            'is_active' => true,
        ]);

        Product::factory()->create([
            'name' => 'Nomad Pants',
            'description' => 'Daily utility style',
            'stock_qty' => 5,
            'is_active' => true,
        ]);

        $this->get(route('storefront.products.index', [
            'q' => 'Atlas',
            'stock' => 'in_stock',
            'sort' => 'newest',
        ]))
            ->assertOk()
            ->assertSee('Atlas Boots')
            ->assertDontSee('Atlas Jacket')
            ->assertDontSee('Nomad Pants');
    }

    public function test_storefront_list_applies_selected_sort_order(): void
    {
        Product::factory()->create([
            'name' => 'Budget Pick',
            'price' => 100.00,
            'is_active' => true,
        ]);

        Product::factory()->create([
            'name' => 'Premium Pick',
            'price' => 450.00,
            'is_active' => true,
        ]);

        $this->get(route('storefront.products.index', [
            'sort' => 'price_desc',
        ]))
            ->assertOk()
            ->assertSeeInOrder(['Premium Pick', 'Budget Pick']);
    }

    public function test_home_uses_shared_product_card_actions(): void
    {
        Product::factory()->create([
            'name' => 'Shared Card Product',
            'description' => 'Shared card body copy',
            'currency' => 'BDT',
            'price' => 350.00,
            'stock_qty' => 5,
            'is_active' => true,
        ]);

        $this->get(route('storefront.home'))
            ->assertOk()
            ->assertSee('Shared Card Product')
            ->assertSee('In stock')
            ->assertSee('Add to cart')
            ->assertSee('Details');
    }

    public function test_home_category_section_shows_eight_root_categories_only(): void
    {
        Category::query()->delete();

        foreach (range(1, 10) as $index) {
            $name = sprintf('Root Category %02d', $index);

            Category::factory()->create([
                'name' => $name,
                'slug' => sprintf('root-category-%02d', $index),
                'parent_id' => null,
            ]);
        }

        $response = $this->get(route('storefront.home'))
            ->assertOk();

        foreach (range(1, 8) as $index) {
            $response->assertSee(sprintf('Root Category %02d', $index));
        }

        $response
            ->assertDontSee('Root Category 09')
            ->assertDontSee('Root Category 10');
    }

    public function test_all_categories_page_shows_root_categories_and_subcategories(): void
    {
        Category::query()->delete();

        $rootCategory = Category::factory()->create([
            'name' => 'Test Root Category',
            'slug' => 'test-root-category',
            'parent_id' => null,
        ]);

        Category::factory()->create([
            'name' => 'Test Subcategory A',
            'slug' => 'test-root-category-a',
            'parent_id' => $rootCategory->id,
        ]);

        Category::factory()->create([
            'name' => 'Test Subcategory B',
            'slug' => 'test-root-category-b',
            'parent_id' => $rootCategory->id,
        ]);

        $this->get(route('storefront.categories.index'))
            ->assertOk()
            ->assertSee('All Categories')
            ->assertSee('Test Root Category')
            ->assertSee('Test Subcategory A')
            ->assertSee('Test Subcategory B');
    }
}
