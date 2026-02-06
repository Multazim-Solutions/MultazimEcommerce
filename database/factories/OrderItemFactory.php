<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $qty = fake()->numberBetween(1, 5);
        $price = fake()->randomFloat(2, 50, 2000);

        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'name_snapshot' => fake()->words(3, true),
            'price_snapshot' => $price,
            'qty' => $qty,
            'line_total' => $price * $qty,
        ];
    }
}
