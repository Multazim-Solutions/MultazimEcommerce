<?php

declare(strict_types=1);

namespace Tests\Feature\Storefront;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_requires_fields(): void
    {
        $this->post(route('storefront.checkout.store'), [])
            ->assertSessionHasErrors([
                'full_name',
                'email',
                'phone',
                'address_line1',
                'city',
                'postal_code',
            ]);
    }

    public function test_checkout_rejects_empty_cart(): void
    {
        $payload = [
            'full_name' => 'Test Customer',
            'email' => 'test@example.com',
            'phone' => '0123456789',
            'address_line1' => '123 Main Street',
            'address_line2' => 'Suite 4',
            'city' => 'Dhaka',
            'postal_code' => '1205',
        ];

        $this->post(route('storefront.checkout.store'), $payload)
            ->assertSessionHasErrors(['cart']);
    }
}
