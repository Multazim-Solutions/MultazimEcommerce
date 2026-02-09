<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Data\Storefront\CategoryCatalog;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $subcategoryEntry = CategoryCatalog::randomSubcategoryEntry();
        $categoryId = $this->resolveSubcategoryId($subcategoryEntry['root'], $subcategoryEntry['subcategory']);
        $productName = $this->resolveProductName($subcategoryEntry['subcategory'], $subcategoryEntry['product_names']);

        return [
            'category_id' => $categoryId,
            'name' => $productName,
            'slug' => Str::slug($productName).'-'.fake()->unique()->numerify('#####'),
            'description' => sprintf('Top-quality picks in %s for everyday use.', $subcategoryEntry['subcategory']),
            'price' => fake()->randomFloat(2, 50, 5000),
            'currency' => 'BDT',
            'stock_qty' => fake()->numberBetween(0, 200),
            'is_active' => true,
        ];
    }

    /**
     * @param list<string> $productNames
     */
    private function resolveProductName(string $subcategoryName, array $productNames): string
    {
        if ($productNames !== []) {
            return fake()->randomElement($productNames);
        }

        return sprintf('%s Item', $subcategoryName);
    }

    private function resolveSubcategoryId(string $rootCategoryName, string $subcategoryName): int
    {
        $rootCategory = Category::query()->firstOrCreate(
            ['slug' => Str::slug($rootCategoryName)],
            [
                'name' => $rootCategoryName,
                'parent_id' => null,
            ],
        );

        $subcategory = Category::query()->firstOrCreate(
            ['slug' => Str::slug($rootCategoryName).'-'.Str::slug($subcategoryName)],
            [
                'name' => $subcategoryName,
                'parent_id' => $rootCategory->id,
            ],
        );

        return (int) $subcategory->id;
    }
}
