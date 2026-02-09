<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\Orders\OrderStatusManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class OrderStatusManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_transition_between_valid_statuses(): void
    {
        $manager = new OrderStatusManager;

        $this->assertTrue($manager->canTransition(OrderStatus::Pending, OrderStatus::Paid));
        $this->assertFalse($manager->canTransition(OrderStatus::Paid, OrderStatus::Pending));
        $this->assertTrue($manager->canTransition(OrderStatus::Failed, OrderStatus::Failed));
    }

    public function test_apply_updates_order_status(): void
    {
        $manager = new OrderStatusManager;
        $order = Order::factory()->create([
            'status' => OrderStatus::Pending,
        ]);

        $manager->apply($order, OrderStatus::Paid);

        $this->assertSame(OrderStatus::Paid, $order->refresh()->status);
    }

    public function test_apply_rejects_invalid_transition(): void
    {
        $manager = new OrderStatusManager;
        $order = Order::factory()->create([
            'status' => OrderStatus::Paid,
        ]);

        $this->expectException(ValidationException::class);

        $manager->apply($order, OrderStatus::Pending);
    }
}
