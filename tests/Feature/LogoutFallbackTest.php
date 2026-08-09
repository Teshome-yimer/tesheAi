<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutFallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_logout_fallback_logs_out_user_and_redirects()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->get('/logout')
             ->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_get_admin_logout_fallback_logs_out_admin_and_redirects()
    {
        // Create admin user (role='admin' per app convention)
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
             ->get('/admin/logout')
             ->assertRedirect('/admin/login');

        $this->assertGuest();
    }

    public function test_get_logout_when_guest_redirects_to_login_without_side_effects()
    {
        $this->get('/logout')
             ->assertRedirect('/login');

        $this->assertGuest();
    }
}
