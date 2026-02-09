<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderIndexRequest;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Services\Orders\OrderStatusManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(OrderIndexRequest $request): View
    {
        $query = Order::query()
            ->with('user')
            ->orderByDesc('id');

        $query = $this->applySearch($query, $request->search());

        if ($request->status() !== null) {
            $query->where('status', $request->status());
        }

        $orders = $query
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'filters' => [
                'q' => $request->search(),
                'status' => $request->selectedStatus(),
            ],
            'statuses' => OrderStatus::cases(),
        ]);
    }

    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => OrderStatus::cases(),
        ]);
    }

    public function update(UpdateOrderStatusRequest $request, Order $order, OrderStatusManager $statusManager): RedirectResponse
    {
        $statusManager->apply($order, $request->status());

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('status', 'Order updated');
    }

    private function applySearch(Builder $query, ?string $search): Builder
    {
        if ($search === null) {
            return $query;
        }

        return $query->where(function (Builder $builder) use ($search): void {
            if (ctype_digit($search)) {
                $builder->where('id', (int) $search)
                    ->orWhereHas('user', function (Builder $userQuery) use ($search): void {
                        $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });

                return;
            }

            $builder->whereHas('user', function (Builder $userQuery) use ($search): void {
                $userQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        });
    }
}
