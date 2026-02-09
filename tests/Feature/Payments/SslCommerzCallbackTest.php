<?php

declare(strict_types=1);

namespace Tests\Feature\Payments;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\Payments\PaymentGateway;
use App\Services\Payments\PaymentInitResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SslCommerzCallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_callback_marks_order_paid(): void
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::Pending,
        ]);

        $this->app->instance(PaymentGateway::class, new class implements PaymentGateway
        {
            public function initiate(Order $order, array $customer, array $urls): PaymentInitResponse
            {
                return new PaymentInitResponse('https://example.test', 'order-'.$order->id.'-TEST', 'SESSION');
            }

            public function validate(string $valId): array
            {
                return ['status' => 'VALID'];
            }
        });

        $tranId = 'order-'.$order->id.'-TEST';

        $this->post(route('payments.sslcommerz.success'), [
            'tran_id' => $tranId,
            'val_id' => 'VAL123',
        ])
            ->assertOk()
            ->assertViewIs('payments.success');

        $order->refresh();
        $this->assertSame(OrderStatus::Paid, $order->status);
        $this->assertSame('sslcommerz', $order->payment_provider);
        $this->assertSame('VAL123', $order->payment_ref);
    }

    public function test_fail_callback_marks_order_failed(): void
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::Pending,
        ]);

        $tranId = 'order-'.$order->id.'-FAIL';

        $this->post(route('payments.sslcommerz.fail'), [
            'tran_id' => $tranId,
        ])
            ->assertOk()
            ->assertViewIs('payments.fail');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'failed',
        ]);
    }

    public function test_cancel_callback_marks_order_cancelled(): void
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::Pending,
        ]);

        $tranId = 'order-'.$order->id.'-CANCEL';

        $this->post(route('payments.sslcommerz.cancel'), [
            'tran_id' => $tranId,
        ])
            ->assertOk()
            ->assertViewIs('payments.cancel');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_paid_order_remains_paid_on_failed_callback(): void
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::Paid,
        ]);

        $tranId = 'order-'.$order->id.'-PAID';

        $this->post(route('payments.sslcommerz.fail'), [
            'tran_id' => $tranId,
        ])
            ->assertOk()
            ->assertViewIs('payments.success');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
        ]);
    }
}
