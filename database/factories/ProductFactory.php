<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @var list<string>
     */
    private const CATEGORY_NAMES = [
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

    public function definition(): array
    {
        $categoryName = fake()->randomElement(self::CATEGORY_NAMES);

        return [
            'name' => $categoryName,
            'slug' => Str::slug($categoryName).'-'.fake()->unique()->numerify('#####'),
            'description' => sprintf('Top-quality picks in %s for everyday use.', $categoryName),
            'price' => fake()->randomFloat(2, 50, 5000),
            'currency' => 'BDT',
            'stock_qty' => fake()->numberBetween(0, 200),
            'is_active' => true,
        ];
    }
}
