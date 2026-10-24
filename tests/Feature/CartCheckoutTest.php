<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function product(int $stock = 5): Product
    {
        $seller = User::create([
            'name' => 'Seller Test',
            'email' => 'seller-cart@example.test',
            'password' => 'password',
            'role' => 'seller',
        ]);
        $umkm = Umkm::create([
            'user_id' => $seller->id,
            'name' => 'UMKM Test',
            'slug' => 'umkm-test',
            'description' => 'UMKM test',
            'address' => 'Tanjungpinang',
            'phone' => '08123456789',
            'email' => 'umkm@example.test',
            'status' => 'approved',
        ]);
        $category = Category::create(['name' => 'Kuliner', 'slug' => 'kuliner-test', 'type' => 'product']);

        return Product::create([
            'umkm_id' => $umkm->id,
            'category_id' => $category->id,
            'name' => 'Produk Test',
            'slug' => 'produk-test-'.$stock,
            'description' => 'Produk test',
            'price' => 10000,
            'stock' => $stock,
            'status' => 'active',
        ]);
    }

    public function test_buyer_can_add_update_and_remove_cart_item(): void
    {
        $buyer = User::create(['name' => 'Buyer Cart', 'email' => 'buyer-cart@example.test', 'password' => 'password', 'role' => 'buyer']);
        $product = $this->product();

        $this->actingAs($buyer)->post(route('cart.add', $product->id), ['quantity' => 2])->assertRedirect(route('cart.index'));
        $cart = $buyer->carts()->first();
        $this->assertSame(2, $cart->quantity);

        $this->actingAs($buyer)->put(route('cart.update', $cart->id), ['quantity' => 3])->assertRedirect();
        $this->assertSame(3, $cart->fresh()->quantity);

        $this->actingAs($buyer)->delete(route('cart.remove', $cart->id))->assertRedirect();
        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }

    public function test_checkout_creates_order_and_decrements_stock(): void
    {
        $buyer = User::create(['name' => 'Buyer Checkout', 'email' => 'buyer-checkout-cart@example.test', 'password' => 'password', 'role' => 'buyer']);
        $product = $this->product(5);

        $this->actingAs($buyer)->post(route('cart.add', $product->id), ['quantity' => 2]);
        $response = $this->actingAs($buyer)->post(route('checkout.process'), [
            'shipping_name' => 'Buyer Checkout',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Tanjungpinang',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', ['user_id' => $buyer->id, 'subtotal' => 20000]);
        $this->assertSame(3, $product->fresh()->stock);
        $this->assertDatabaseCount('carts', 0);
    }
}
