<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessAndCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_checkout(): void
    {
        $response = $this->get(route('checkout'));

        $response->assertRedirect(route('login'));
    }

    public function test_buyer_with_empty_cart_is_redirected_from_checkout(): void
    {
        $buyer = User::create([
            'name' => 'Buyer Test',
            'email' => 'buyer-checkout@example.test',
            'password' => 'password',
            'role' => 'buyer',
        ]);

        $response = $this->actingAs($buyer)->get(route('checkout'));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error', 'Keranjang kosong.');
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $buyer = User::create([
            'name' => 'Buyer Admin Test',
            'email' => 'buyer-admin@example.test',
            'password' => 'password',
            'role' => 'buyer',
        ]);

        $response = $this->actingAs($buyer)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }
}
