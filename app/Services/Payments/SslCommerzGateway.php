<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class SslCommerzGateway implements PaymentGateway
{
    public function initiate(Order $order, array $customer, array $urls): PaymentInitResponse
    {
        $storeId = (string) config('services.sslcommerz.store_id');
        $storePassword = (string) config('services.sslcommerz.store_password');

        if ($storeId === '' || $storePassword === '') {
            throw new RuntimeException('SSLCommerz credentials are missing.');
        }

        $tranId = 'order-'.$order->id.'-'.Str::upper(Str::random(6));
        $endpoint = $this->baseUrl().'/gwprocess/v4/api.php';

        $payload = [
            'store_id' => $storeId,
            'store_passwd' => $storePassword,
            'total_amount' => $order->total,
            'currency' => $order->currency,
            'tran_id' => $tranId,
            'success_url' => $urls['success'],
            'fail_url' => $urls['fail'],
            'cancel_url' => $urls['cancel'],
            'ipn_url' => $urls['ipn'] ?? null,
            'cus_name' => $customer['name'],
            'cus_email' => $customer['email'],
            'cus_add1' => $customer['address_line1'],
            'cus_add2' => $customer['address_line2'] ?? '',
            'cus_city' => $customer['city'],
            'cus_postcode' => $customer['postal_code'],
            'cus_phone' => $customer['phone'],
            'shipping_method' => 'NO',
            'num_of_item' => max(1, $order->items()->count()),
            'product_name' => 'Order #'.$order->id,
            'product_category' => 'Ecommerce',
            'product_profile' => 'general',
        ];

        $response = Http::asForm()->post($endpoint, Arr::whereNotNull($payload));

        if (! $response->ok()) {
            throw new RuntimeException('SSLCommerz init request failed.');
        }

        $data = $response->json();
        $redirectUrl = $data['GatewayPageURL'] ?? null;

        if (! is_string($redirectUrl) || $redirectUrl === '') {
            throw new RuntimeException('SSLCommerz did not return a gateway URL.');
        }

        return new PaymentInitResponse(
            redirectUrl: $redirectUrl,
            tranId: $tranId,
            sessionKey: $data['sessionkey'] ?? null,
        );
    }

    public function validate(string $valId): array
    {
        $storeId = (string) config('services.sslcommerz.store_id');
        $storePassword = (string) config('services.sslcommerz.store_password');

        $endpoint = $this->baseUrl().'/validator/api/validationserverAPI.php';

        $response = Http::get($endpoint, [
            'val_id' => $valId,
            'store_id' => $storeId,
            'store_passwd' => $storePassword,
            'format' => 'json',
        ]);

        if (! $response->ok()) {
            throw new RuntimeException('SSLCommerz validation request failed.');
        }

        return $response->json();
    }

    private function baseUrl(): string
    {
        $sandbox = (bool) config('services.sslcommerz.sandbox', true);

        return $sandbox
            ? 'https://sandbox.sslcommerz.com'
            : 'https://securepay.sslcommerz.com';
    }
}
