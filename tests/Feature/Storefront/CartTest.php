<?php

declare(strict_types=1);

namespace Tests\Feature\Storefront;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_add_update_and_remove_flow(): void
    {
        $product = Product::factory()->create([
            'price' => 199.99,
        ]);

        $this->post(route('storefront.cart.add'), [
            'product_id' => $product->id,
            'qty' => 2,
        ])->assertRedirect(route('storefront.cart.index'));

        $cartItem = CartItem::query()->firstOrFail();
        $this->assertSame(2, $cartItem->qty);

        $this->patch(route('storefront.cart.update', $cartItem), [
            'qty' => 3,
        ])->assertRedirect(route('storefront.cart.index'));

        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'qty' => 3,
        ]);

        $this->delete(route('storefront.cart.remove', $cartItem))
            ->assertRedirect(route('storefront.cart.index'));

        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id,
        ]);
    }
}
