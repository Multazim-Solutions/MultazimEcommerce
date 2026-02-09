<?php

declare(strict_types=1);

namespace App\Data\Admin;

final readonly class AdminDashboardStats
{
    public function __construct(
        public int $totalProducts,
        public int $activeProducts,
        public int $lowStockProducts,
        public int $pendingOrders,
        public int $paidOrders,
        public float $paidRevenue,
    ) {}
}
