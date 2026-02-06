<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Payments\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class SslCommerzController extends Controller
{
    public function success(Request $request, PaymentGateway $gateway): View
    {
        return $this->handleCallback($request, $gateway, 'success');
    }

    public function fail(Request $request): View
    {
        return $this->handleCallback($request, null, 'fail');
    }

    public function cancel(Request $request): View
    {
        return $this->handleCallback($request, null, 'cancel');
    }

    public function ipn(Request $request, PaymentGateway $gateway): Response
    {
        $this->handleCallback($request, $gateway, 'ipn');

        return response('OK');
    }

    private function handleCallback(Request $request, ?PaymentGateway $gateway, string $type): View
    {
        $tranId = (string) $request->input('tran_id', '');

        if ($tranId === '') {
            abort(400, 'Missing transaction id.');
        }

        $order = $this->resolveOrder($tranId);

        if ($order === null) {
            abort(404);
        }

        if ($order->status === 'paid') {
            return view('payments.success', ['order' => $order]);
        }

        if ($type === 'success' || $type === 'ipn') {
            $valId = (string) $request->input('val_id', '');

            if ($valId === '' || $gateway === null) {
                return $this->markFailed($order, $type, 'Missing validation id.');
            }

            $validation = $gateway->validate($valId);
            $status = strtoupper((string) ($validation['status'] ?? ''));

            if (in_array($status, ['VALID', 'VALIDATED'], true)) {
                $order->update([
                    'status' => 'paid',
                    'payment_provider' => 'sslcommerz',
                    'payment_ref' => $valId,
                ]);

                return view('payments.success', ['order' => $order]);
            }

            return $this->markFailed($order, $type, 'Payment validation failed.');
        }

        if ($type === 'cancel') {
            $order->update(['status' => 'cancelled']);

            return view('payments.cancel', ['order' => $order]);
        }

        $order->update(['status' => 'failed']);

        return view('payments.fail', ['order' => $order]);
    }

    private function markFailed(Order $order, string $type, string $message): View
    {
        Log::channel('payments')->warning('SSLCommerz callback failed', [
            'order_id' => $order->id,
            'type' => $type,
            'message' => $message,
        ]);

        if ($order->status === 'paid') {
            return view('payments.success', ['order' => $order]);
        }

        $order->update(['status' => 'failed']);

        return view('payments.fail', ['order' => $order]);
    }

    private function resolveOrder(string $tranId): ?Order
    {
        if (preg_match('/^order-(\d+)-/i', $tranId, $matches) === 1) {
            return Order::find((int) $matches[1]);
        }

        return null;
    }
}
