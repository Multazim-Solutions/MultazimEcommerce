<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;

class ProductFactoryCategoryNamesTest extends TestCase
{
    public function test_product_factory_uses_predefined_category_names(): void
    {
        $allowedCategoryNames = [
            'Mobile Accessories',
            'T-Shirt',
            'Watches',
            'Islamic Corner',
            'Shirts',
            'Kitchen & Dining',
            'Bag',
            'Health & Beauty',
            'Content Tools',
            'Electronics',
            'Speaker',
            'Home Appliance',
            'Bed Sheet',
            'Transparent Toys',
            'Borka',
            'Shaver & Trimmer',
        ];

        for ($index = 0; $index < 64; $index++) {
            $product = Product::factory()->make();

            $this->assertContains(
                $product->name,
                $allowedCategoryNames,
                sprintf('Factory generated unexpected category name: %s', $product->name),
            );
        }
    }
}
