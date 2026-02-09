<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Data\Storefront\CategoryCatalog;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFactoryCategoryNamesTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_factory_assigns_products_to_subcategories_from_catalog(): void
    {
        $allowedProductNames = CategoryCatalog::allProductNames();

        for ($index = 0; $index < 64; $index++) {
            $product = Product::factory()->create();

            $this->assertNotNull($product->category, 'Product category must be assigned.');
            $this->assertNotNull($product->category?->parent, 'Product must be assigned to a subcategory.');

            $isKnownMockProductName = in_array($product->name, $allowedProductNames, true);
            $usesFallbackName = str_ends_with($product->name, ' Item');
            $this->assertTrue(
                $isKnownMockProductName || $usesFallbackName,
                sprintf('Factory generated unexpected mock product name: %s', $product->name),
            );
        }
    }
}
