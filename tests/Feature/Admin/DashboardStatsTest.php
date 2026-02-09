<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_displays_operational_stats(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        Product::factory()->count(2)->create([
            'is_active' => true,
            'stock_qty' => 10,
        ]);

        Product::factory()->create([
            'is_active' => false,
            'stock_qty' => 2,
        ]);

        Order::factory()->create([
            'status' => OrderStatus::Pending,
            'total' => 150.00,
        ]);

        Order::factory()->create([
            'status' => OrderStatus::Paid,
            'total' => 200.50,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Total products')
            ->assertSee('3')
            ->assertSee('Paid revenue')
            ->assertSee('BDT 200.50');
    }
}
