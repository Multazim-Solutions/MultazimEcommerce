<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_route_redirects_to_login_with_admin_flag(): void
    {
        $this->get(route('admin.login'))
            ->assertRedirect(route('login', ['admin' => '1']));
    }

    public function test_login_page_shows_admin_hint_when_admin_flag_is_present(): void
    {
        $this->get(route('login', ['admin' => '1']))
            ->assertOk()
            ->assertSee('Admin sign-in');
    }

    public function test_admin_routes_require_authentication(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_routes_forbid_non_admin_users(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }
}
