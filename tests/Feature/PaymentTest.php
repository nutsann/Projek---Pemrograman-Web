<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_upload_payment_proof(): void
    {
        Storage::fake('public');
        $buyer = User::create(['name' => 'Buyer Payment', 'email' => 'buyer-payment@example.test', 'password' => 'password', 'role' => 'buyer']);
        $order = Order::create([
            'order_number' => 'ORD-PAYMENT-1',
            'user_id' => $buyer->id,
            'subtotal' => 20000,
            'shipping_cost' => 0,
            'total' => 20000,
            'shipping_name' => 'Buyer Payment',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Tanjungpinang',
            'payment_method' => 'bank_transfer',
            'payment_status' => 'unpaid',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($buyer)->post(route('orders.payment-proof', $order->id), [
            'payment_proof' => UploadedFile::fake()->create('proof.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect();
        $this->assertSame('waiting_verification', $order->fresh()->payment_status);
        Storage::disk('public')->assertExists($order->fresh()->payment_proof);
    }

    public function test_admin_can_verify_payment(): void
    {
        $admin = User::create(['name' => 'Admin Payment', 'email' => 'admin-payment@example.test', 'password' => 'password', 'role' => 'admin']);
        $buyer = User::create(['name' => 'Buyer Verify', 'email' => 'buyer-verify@example.test', 'password' => 'password', 'role' => 'buyer']);
        $order = Order::create([
            'order_number' => 'ORD-PAYMENT-2',
            'user_id' => $buyer->id,
            'subtotal' => 20000,
            'shipping_cost' => 0,
            'total' => 20000,
            'shipping_name' => 'Buyer Verify',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Tanjungpinang',
            'payment_method' => 'qris',
            'payment_status' => 'waiting_verification',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.order.payment-status', $order->id), ['payment_status' => 'paid']);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'payment_status' => 'paid']);
    }
}
