<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Data\Admin\AdminDashboardStats;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = new AdminDashboardStats(
            totalProducts: Product::query()->count(),
            activeProducts: Product::query()->where('is_active', true)->count(),
            lowStockProducts: Product::query()->where('stock_qty', '<=', 5)->count(),
            pendingOrders: Order::query()->where('status', OrderStatus::Pending)->count(),
            paidOrders: Order::query()->where('status', OrderStatus::Paid)->count(),
            paidRevenue: (float) (Order::query()->where('status', OrderStatus::Paid)->sum('total')),
        );

        return view('admin.dashboard', [
            'stats' => $stats,
        ]);
    }
}
