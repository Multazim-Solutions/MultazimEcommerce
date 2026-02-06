<?php

declare(strict_types=1);

namespace App\Services\Orders;

use Illuminate\Support\Collection;

class OrderTotalCalculator
{
    /**
     * @param Collection<int, mixed> $items
     */
    public function calculate(Collection $items, float $shipping = 0.0, float $tax = 0.0): OrderTotals
    {
        $subtotal = $items->sum(function ($item): float {
            $price = (float) ($item->product?->price ?? 0);

            return $price * (int) $item->qty;
        });

        return new OrderTotals($subtotal, $shipping, $tax);
    }
}
