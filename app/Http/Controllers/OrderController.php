<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Notifications\OrderNotification;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function checkout()
    {
        $buyNow = session('buy_now');
        if ($buyNow) {
            $carts = Cart::with('product.umkm')->where('user_id', Auth::id())->where('product_id', $buyNow['product_id'])->get();
            $product = \App\Models\Product::with('umkm')->findOrFail($buyNow['product_id']);
            $virtualCart = new Cart(['product_id' => $product->id, 'quantity' => $buyNow['quantity']]);
            $virtualCart->setRelation('product', $product);
            $carts = collect([$virtualCart]);
        } else {
            $carts = Cart::with('product.umkm')->where('user_id', Auth::id())->get();
        }
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }
        $subtotal = $carts->sum(fn ($c) => $c->product->price * $c->quantity);

        return view('orders.checkout', [
            'carts' => $carts,
            'subtotal' => $subtotal,
            'user' => Auth::user(),
        ]);
    }

    public function process(Request $req)
    {
        if ($req->session()->pull('checkout_submitted', false)) {
            return redirect()->route('orders.index')->with('error', 'Pesanan sudah diproses.');
        }

        $validated = $req->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_area' => 'nullable|in:tanjungpinang,kijang,bintan_lainnya,luar_daerah',
            'payment_method' => 'nullable|in:cod,bank_transfer,qris',
            'notes' => 'nullable|string',
        ]);

        $buyNow = session('buy_now');
        if ($buyNow) {
            $product = \App\Models\Product::findOrFail($buyNow['product_id']);
            $virtualCart = new Cart([
                'product_id' => $product->id,
                'quantity' => (int) $buyNow['quantity'],
            ]);
            $virtualCart->setRelation('product', $product);
            $carts = collect([$virtualCart]);
        } else {
            $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        }
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $shippingCosts = [
            'tanjungpinang' => 0,
            'kijang' => 10000,
            'bintan_lainnya' => 15000,
            'luar_daerah' => 30000,
        ];
        $shippingCost = $shippingCosts[$validated['shipping_area'] ?? 'tanjungpinang'];

        try {
            $order = DB::transaction(function () use ($carts, $validated, $shippingCost) {
                if (session('buy_now')) {
                    $buyNow = session('buy_now');
                    $product = \App\Models\Product::lockForUpdate()->findOrFail($buyNow['product_id']);
                    $virtualCart = new Cart([
                        'product_id' => $product->id,
                        'quantity' => (int) $buyNow['quantity'],
                    ]);
                    $virtualCart->setRelation('product', $product);
                    $lockedCarts = collect([$virtualCart]);
                } else {
                    $lockedCarts = Cart::with('product')->where('user_id', Auth::id())->lockForUpdate()->get();
                }
                if ($lockedCarts->isEmpty()) {
                    throw new \RuntimeException('Keranjang kosong.');
                }
                foreach ($lockedCarts as $cart) {
                    if (! $cart->product || $cart->product->status !== 'active') {
                        throw new \RuntimeException('Produk tidak tersedia.');
                    }
                    if ($cart->quantity < 1 || $cart->product->stock < $cart->quantity) {
                        throw new \RuntimeException('Stok '.$cart->product->name.' tidak mencukupi.');
                    }
                }
                $carts = $lockedCarts;
                $subtotal = $carts->sum(fn ($cart) => $cart->product->price * $cart->quantity);
                $order = Order::create([
                    'order_number' => 'ORD-'.strtoupper(Str::random(8)),
                    'user_id' => Auth::id(),
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'total' => $subtotal + $shippingCost,
                    'shipping_name' => $validated['shipping_name'],
                    'shipping_phone' => $validated['shipping_phone'],
                    'shipping_address' => $validated['shipping_address'],
                    'payment_method' => $validated['payment_method'] ?? 'cod',
                    'payment_status' => ($validated['payment_method'] ?? 'cod') === 'cod' ? 'paid' : 'unpaid',
                    'status' => 'pending',
                    'notes' => $validated['notes'] ?? null,
                ]);
                foreach ($carts as $cart) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cart->product_id,
                        'umkm_id' => $cart->product->umkm_id,
                        'product_name' => $cart->product->name,
                        'quantity' => $cart->quantity,
                        'price' => $cart->product->price,
                        'subtotal' => $cart->product->price * $cart->quantity,
                    ]);
                    $cart->product->decrement('stock', $cart->quantity);
                }
                if (session('buy_now')) {
                    session()->forget('buy_now');
                } else {
                    Cart::where('user_id', Auth::id())->delete();
                }

                return $order;
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        $req->session()->put('checkout_submitted', true);
        Auth::user()->notify(new OrderNotification($order, 'Pesanan berhasil dibuat dan menunggu konfirmasi.'));

        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat.');
    }

    public function pay($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->payment_method === 'cod' || $order->payment_status === 'paid') {
            return back()->with('error', 'Order tidak memerlukan pembayaran online.');
        }

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->shipping_name,
                'phone' => $order->shipping_phone,
            ],
        ]);

        return view('orders.pay', compact('order', 'snapToken'));
    }

    public function show($id)
    {
        $order = Order::with('items.product.umkm')->where('user_id', Auth::id())->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function cancel($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $order = Order::with('items')->where('user_id', Auth::id())->lockForUpdate()->findOrFail($id);

                if ($order->status !== 'pending') {
                    throw new \RuntimeException('Pesanan hanya bisa dibatalkan saat masih menunggu konfirmasi.');
                }

                foreach ($order->items as $item) {
                    $item->product()->lockForUpdate()->first()?->increment('stock', $item->quantity);
                }

                $order->update(['status' => 'cancelled', 'payment_status' => 'failed']);
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        Auth::user()->notify(new OrderNotification(Order::findOrFail($id), 'Pesanan berhasil dibatalkan.'));

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function uploadPaymentProof(Request $req, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (! in_array($order->payment_method, ['bank_transfer', 'qris'], true)) {
            return back()->with('error', 'Bukti pembayaran hanya diperlukan untuk Transfer Bank atau QRIS.');
        }

        $validated = $req->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $path = $validated['payment_proof']->store('payment-proofs', 'public');
        $order->update(['payment_proof' => $path, 'payment_status' => 'waiting_verification']);
        Auth::user()->notify(new OrderNotification($order, 'Bukti pembayaran berhasil dikirim dan menunggu verifikasi.'));

        return back()->with('success', 'Bukti pembayaran berhasil dikirim dan menunggu verifikasi.');
    }

    public function index()
    {
        $orders = Order::with('items')->where('user_id', Auth::id())->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function orderSuccess($id)
    {
        $order = Order::with('items.product.umkm')->where('user_id', Auth::id())->findOrFail($id);

        return view('orders.success', compact('order'));
    }

    public function orderStatus()
    {
        $orders = Order::with('items.product.umkm')->where('user_id', Auth::id())->latest()->paginate(10);

        return view('orders.status', compact('orders'));
    }

    public function orderHistory()
    {
        $orders = Order::with('items.product.umkm')->where('user_id', Auth::id())->latest()->paginate(10);

        return view('orders.history', compact('orders'));
    }
}
