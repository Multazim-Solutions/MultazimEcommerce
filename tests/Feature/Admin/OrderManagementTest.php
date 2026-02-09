<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_order_status(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $order = Order::factory()->create([
            'status' => OrderStatus::Pending,
        ]);

        $this->actingAs($admin)
            ->put(route('admin.orders.update', $order), [
                'status' => 'paid',
            ])
            ->assertRedirect(route('admin.orders.show', $order));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
        ]);
    }

    public function test_invalid_order_status_transition_is_rejected(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $order = Order::factory()->create([
            'status' => OrderStatus::Paid,
        ]);

        $this->actingAs($admin)
            ->from(route('admin.orders.show', $order))
            ->put(route('admin.orders.update', $order), [
                'status' => 'pending',
            ])
            ->assertSessionHasErrors(['status']);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
        ]);
    }

    public function test_admin_can_filter_orders_by_status(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $paidOrder = Order::factory()->create([
            'status' => OrderStatus::Paid,
        ]);

        $pendingOrder = Order::factory()->create([
            'status' => OrderStatus::Pending,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.orders.index', ['status' => OrderStatus::Pending->value]))
            ->assertOk()
            ->assertSee('#'.$pendingOrder->id)
            ->assertDontSee('#'.$paidOrder->id);
    }
}
