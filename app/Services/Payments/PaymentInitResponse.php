<?php

declare(strict_types=1);

namespace App\Services\Payments;

final class PaymentInitResponse
{
    public function __construct(
        public string $redirectUrl,
        public string $tranId,
        public ?string $sessionKey = null,
    ) {
    }
}
