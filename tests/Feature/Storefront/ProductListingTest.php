<?php

declare(strict_types=1);

namespace Tests\Feature\Storefront;

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
            ->assertSee('Active Product');
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
}
