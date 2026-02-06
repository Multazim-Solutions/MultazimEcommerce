<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $cart = $this->resolveCart($request);
        $cart->load('items.product');

        return response()->json($cart);
    }

    public function store(AddCartItemRequest $request): JsonResponse
    {
        $data = $request->validated();
        $cart = $this->resolveCart($request);

        $item = $cart->items()
            ->where('product_id', $data['product_id'])
            ->first();

        if ($item === null) {
            $item = $cart->items()->create([
                'product_id' => $data['product_id'],
                'qty' => $data['qty'],
            ]);
        } else {
            $item->update([
                'qty' => $item->qty + $data['qty'],
            ]);
        }

        $cart->load('items.product');

        return response()->json($cart, 201);
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem): JsonResponse
    {
        $cart = $this->resolveCart($request);
        $this->ensureCartOwnership($cart, $cartItem);

        $cartItem->update($request->validated());
        $cart->load('items.product');

        return response()->json($cart);
    }

    public function destroy(Request $request, CartItem $cartItem): JsonResponse
    {
        $cart = $this->resolveCart($request);
        $this->ensureCartOwnership($cart, $cartItem);

        $cartItem->delete();
        $cart->load('items.product');

        return response()->json($cart);
    }

    private function resolveCart(Request $request): Cart
    {
        $user = $request->user();
        $sessionId = $request->hasSession() ? $request->session()->getId() : null;

        if ($user === null) {
            abort(401);
        }

        return Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['session_id' => $sessionId]
        );
    }

    private function ensureCartOwnership(Cart $cart, CartItem $cartItem): void
    {
        if ($cartItem->cart_id !== $cart->id) {
            abort(404);
        }
    }
}
