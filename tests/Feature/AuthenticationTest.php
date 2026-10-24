<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_email(): void
    {
        User::create([
            'name' => 'Pembeli Uji',
            'email' => 'buyer@example.test',
            'password' => Hash::make('password'),
            'role' => 'buyer',
        ]);

        $response = $this->post(route('login.post'), [
            'identifier' => 'buyer@example.test',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
    }

    public function test_user_can_login_with_username(): void
    {
        User::create([
            'name' => 'username-test',
            'email' => 'username@example.test',
            'password' => Hash::make('password'),
            'role' => 'buyer',
        ]);

        $response = $this->post(route('login.post'), [
            'identifier' => 'username-test',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::create(['name' => 'Admin Test', 'email' => 'admin@example.test', 'password' => 'password', 'role' => 'admin']);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_seller_cannot_access_admin_dashboard(): void
    {
        $seller = User::create(['name' => 'Seller Test', 'email' => 'seller@example.test', 'password' => 'password', 'role' => 'seller']);

        $this->actingAs($seller)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_buyer_cannot_access_seller_dashboard(): void
    {
        $buyer = User::create(['name' => 'Buyer Test', 'email' => 'buyer-role@example.test', 'password' => 'password', 'role' => 'buyer']);

        $this->actingAs($buyer)->get(route('umkm.dashboard'))->assertForbidden();
    }

    public function test_user_can_logout(): void
    {
        $user = User::create(['name' => 'Logout Test', 'email' => 'logout@example.test', 'password' => 'password', 'role' => 'buyer']);

        $this->actingAs($user)->post(route('logout'))->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_invalid_login_is_rejected(): void
    {
        $response = $this->post(route('login.post'), [
            'identifier' => 'unknown@example.test',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHas('error');
        $this->assertGuest();
    }
}
