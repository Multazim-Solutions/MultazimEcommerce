<?php

declare(strict_types=1);

namespace App\Services\Orders;

final class OrderTotals
{
    public function __construct(
        public float $subtotal,
        public float $shipping,
        public float $tax,
    ) {
    }

    public function total(): float
    {
        return $this->subtotal + $this->shipping + $this->tax;
    }
}
