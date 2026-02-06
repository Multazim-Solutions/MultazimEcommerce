<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 100, 5000);
        $shipping = fake()->randomFloat(2, 0, 500);
        $tax = fake()->randomFloat(2, 0, 300);

        return [
            'user_id' => User::factory(),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $subtotal + $shipping + $tax,
            'currency' => 'BDT',
            'payment_provider' => null,
            'payment_ref' => null,
        ];
    }
}
