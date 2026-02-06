<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Services\Orders\OrderStatusManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->with('user')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    public function update(UpdateOrderStatusRequest $request, Order $order, OrderStatusManager $statusManager): RedirectResponse
    {
        $statusManager->apply($order, $request->validated()['status']);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('status', 'Order updated');
    }
}
