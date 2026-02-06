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

        DB::transaction(function () use ($cart, $request): void {
            Order::create([
                'user_id' => $request->user()?->id,
                'status' => 'pending',
                'subtotal' => 0,
                'shipping' => 0,
                'tax' => 0,
                'total' => 0,
                'currency' => $cart->items->first()?->product?->currency ?? 'BDT',
                'payment_provider' => null,
                'payment_ref' => null,
            ]);
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
