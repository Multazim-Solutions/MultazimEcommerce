<?php

declare(strict_types=1);

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\Orders\OrderTotalCalculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request, OrderTotalCalculator $calculator): View
    {
        $cart = $this->resolveCart($request);
        $cart->load('items.product');
        $totals = $calculator->calculate($cart->items, shipping: 0.0, tax: 0.0);
        $currency = $cart->items->first()?->product?->currency ?? 'BDT';

        return view('storefront.cart.index', [
            'cart' => $cart,
            'totals' => $totals,
            'currency' => $currency,
        ]);
    }

    public function store(AddCartItemRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $cart = $this->resolveCart($request);

        $item = $cart->items()
            ->where('product_id', $data['product_id'])
            ->first();

        if ($item === null) {
            $cart->items()->create([
                'product_id' => $data['product_id'],
                'qty' => $data['qty'],
            ]);
        } else {
            $item->update([
                'qty' => $item->qty + $data['qty'],
            ]);
        }

        return redirect()
            ->route('storefront.cart.index')
            ->with('status', 'Added to cart');
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem): RedirectResponse
    {
        $cart = $this->resolveCart($request);
        $this->ensureCartOwnership($cart, $cartItem);

        $cartItem->update($request->validated());

        return redirect()
            ->route('storefront.cart.index')
            ->with('status', 'Cart updated');
    }

    public function destroy(Request $request, CartItem $cartItem): RedirectResponse
    {
        $cart = $this->resolveCart($request);
        $this->ensureCartOwnership($cart, $cartItem);

        $cartItem->delete();

        return redirect()
            ->route('storefront.cart.index')
            ->with('status', 'Item removed');
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

    private function ensureCartOwnership(Cart $cart, CartItem $cartItem): void
    {
        if ($cartItem->cart_id !== $cart->id) {
            abort(404);
        }
    }
}
