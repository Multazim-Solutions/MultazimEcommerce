<?php

declare(strict_types=1);

namespace Tests\Feature\Storefront;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
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

        $user = User::factory()->create();

        $this->actingAs($user)->post(route('storefront.cart.add'), [
            'product_id' => $product->id,
            'qty' => 2,
        ])->assertRedirect(route('storefront.cart.index'));

        $cartItem = CartItem::query()->firstOrFail();
        $this->assertSame(2, $cartItem->qty);

        $this->actingAs($user)->patch(route('storefront.cart.update', $cartItem), [
            'qty' => 3,
        ])->assertRedirect(route('storefront.cart.index'));

        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'qty' => 3,
        ]);

        $this->actingAs($user)->delete(route('storefront.cart.remove', $cartItem))
            ->assertRedirect(route('storefront.cart.index'));

        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id,
        ]);
    }

    public function test_cart_page_shows_running_totals(): void
    {
        $product = Product::factory()->create([
            'name' => 'Totals Product',
            'price' => 125.50,
            'currency' => 'BDT',
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)->post(route('storefront.cart.add'), [
            'product_id' => $product->id,
            'qty' => 2,
        ])->assertRedirect(route('storefront.cart.index'));

        $this->actingAs($user)
            ->get(route('storefront.cart.index'))
            ->assertOk()
            ->assertSee('Order summary')
            ->assertSee('BDT 251.00');
    }
}
