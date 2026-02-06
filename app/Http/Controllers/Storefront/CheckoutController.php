<?php

declare(strict_types=1);

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function show(): View
    {
        return view('storefront.checkout.show');
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $request->validated();
        $cart = $this->resolveCart($request);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()
                ->route('storefront.checkout.show')
                ->withErrors(['cart' => 'Your cart is empty.']);
        }

        $subtotal = $cart->items->sum(function ($item): float {
            $price = (float) ($item->product?->price ?? 0);

            return $price * $item->qty;
        });

        $shipping = 0;
        $tax = 0;
        $total = $subtotal + $shipping + $tax;

        DB::transaction(function () use ($cart, $request, $subtotal, $shipping, $tax, $total): void {
            $order = Order::create([
                'user_id' => $request->user()?->id,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'currency' => $cart->items->first()?->product?->currency ?? 'BDT',
                'payment_provider' => null,
                'payment_ref' => null,
            ]);

            foreach ($cart->items as $item) {
                $product = $item->product;

                if ($product === null) {
                    throw ValidationException::withMessages([
                        'cart' => 'One of the cart items is no longer available.',
                    ]);
                }

                if ($product->stock_qty < $item->qty) {
                    throw ValidationException::withMessages([
                        'cart' => "Insufficient stock for {$product->name}.",
                    ]);
                }

                $product->decrement('stock_qty', $item->qty);

                $order->items()->create([
                    'product_id' => $product->id,
                    'name_snapshot' => $product->name,
                    'price_snapshot' => $product->price,
                    'qty' => $item->qty,
                    'line_total' => $item->qty * (float) $product->price,
                ]);
            }
        });

        return redirect()
            ->route('storefront.checkout.show')
            ->with('status', 'Order created');
    }

    private function resolveCart(Request $request): Cart
    {
        $user = $request->user();
        $sessionId = $request->session()->getId();

        if ($user !== null) {
            return Cart::firstOrCreate(
                ['user_id' => $user->id],
                ['session_id' => $sessionId]
            );
        }

        return Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => null]
        );
    }
}
