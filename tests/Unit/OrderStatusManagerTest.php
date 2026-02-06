<?php

declare(strict_types=1);

namespace Tests\Unit;

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
        $manager = new OrderStatusManager();

        $this->assertTrue($manager->canTransition('pending', 'paid'));
        $this->assertFalse($manager->canTransition('paid', 'pending'));
        $this->assertTrue($manager->canTransition('failed', 'failed'));
    }

    public function test_apply_updates_order_status(): void
    {
        $manager = new OrderStatusManager();
        $order = Order::factory()->create([
            'status' => 'pending',
        ]);

        $manager->apply($order, 'paid');

        $this->assertSame('paid', $order->refresh()->status);
    }

    public function test_apply_rejects_invalid_transition(): void
    {
        $manager = new OrderStatusManager();
        $order = Order::factory()->create([
            'status' => 'paid',
        ]);

        $this->expectException(ValidationException::class);

        $manager->apply($order, 'pending');
    }
}
