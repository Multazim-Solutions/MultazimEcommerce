<?php

declare(strict_types=1);

namespace App\Services\Orders;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Validation\ValidationException;

class OrderStatusManager
{
    public function canTransition(OrderStatus $from, OrderStatus $to): bool
    {
        return $from->canTransitionTo($to);
    }

    public function apply(Order $order, OrderStatus $to): void
    {
        $from = $order->status;

        if (! $from instanceof OrderStatus) {
            throw ValidationException::withMessages([
                'status' => 'Unknown order status.',
            ]);
        }

        if (! $this->canTransition($from, $to)) {
            throw ValidationException::withMessages([
                'status' => 'Invalid order status transition.',
            ]);
        }

        $order->update(['status' => $to]);
    }
}
