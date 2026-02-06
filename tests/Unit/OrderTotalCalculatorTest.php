<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\CartItem;
use App\Models\Product;
use App\Services\Orders\OrderTotalCalculator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTotalCalculatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculator_sums_items_and_adds_shipping_and_tax(): void
    {
        $product = Product::factory()->create([
            'price' => 150.00,
        ]);

        $item = CartItem::factory()->create([
            'product_id' => $product->id,
            'qty' => 2,
        ]);

        $calculator = new OrderTotalCalculator();
        $totals = $calculator->calculate(collect([$item]), shipping: 20.0, tax: 10.0);

        $this->assertSame(300.0, $totals->subtotal);
        $this->assertSame(20.0, $totals->shipping);
        $this->assertSame(10.0, $totals->tax);
        $this->assertSame(330.0, $totals->total());
    }
}
