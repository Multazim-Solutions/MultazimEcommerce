<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $context = array_filter([
            'request_id' => $request->attributes->get('request_id')
                ?? $request->headers->get('X-Request-Id'),
            'user_id' => $request->user()?->getAuthIdentifier(),
            'order_id' => $this->resolveOrderId($request),
        ], fn ($value) => $value !== null && $value !== '');

        if ($context !== []) {
            Log::withContext($context);
        }

        return $next($request);
    }

    private function resolveOrderId(Request $request): ?int
    {
        $order = $request->route('order');

        if ($order instanceof Order) {
            return $order->id;
        }

        if (is_numeric($order)) {
            return (int) $order;
        }

        $orderId = $request->input('order_id') ?? $request->input('order');

        if (is_numeric($orderId)) {
            return (int) $orderId;
        }

        $tranId = (string) $request->input('tran_id', '');

        if ($tranId !== '' && preg_match('/^order-(\d+)-/i', $tranId, $matches) === 1) {
            return (int) $matches[1];
        }

        return null;
    }
}
