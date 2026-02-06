<?php

declare(strict_types=1);

namespace App\Services\Orders;

use App\Models\Order;
use Illuminate\Validation\ValidationException;

class OrderStatusManager
{
    private array $transitions = [
        'pending' => ['paid', 'failed', 'cancelled'],
        'paid' => ['shipped', 'cancelled'],
        'failed' => [],
        'shipped' => [],
        'cancelled' => [],
    ];

    public function canTransition(string $from, string $to): bool
    {
        if ($from === $to) {
            return true;
        }

        return in_array($to, $this->transitions[$from] ?? [], true);
    }

    public function apply(Order $order, string $to): void
    {
        $from = (string) $order->status;

        if (! $this->canTransition($from, $to)) {
            throw ValidationException::withMessages([
                'status' => 'Invalid order status transition.',
            ]);
        }

        $order->update(['status' => $to]);
    }
}
