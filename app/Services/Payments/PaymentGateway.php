<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Models\Order;

interface PaymentGateway
{
    public function initiate(Order $order, array $customer, array $urls): PaymentInitResponse;

    public function validate(string $valId): array;
}
