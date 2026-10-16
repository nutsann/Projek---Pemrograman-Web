<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        $carts = Cart::with('product.umkm')->where('user_id', Auth::id())->get();
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
        $validated = $req->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        try {
            $order = DB::transaction(function () use ($carts, $validated) {
                foreach ($carts as $cart) {
                    if ($cart->product->stock < $cart->quantity) {
                        throw new \RuntimeException('Stok '.$cart->product->name.' tidak mencukupi.');
                    }
                }
                $subtotal = $carts->sum(fn ($c) => $c->product->price * $c->quantity);
                $order = Order::create([
                    'order_number' => 'ORD-'.strtoupper(Str::random(8)),
                    'user_id' => Auth::id(),
                    'subtotal' => $subtotal,
                    'shipping_cost' => 0,
                    'total' => $subtotal,
                    'shipping_name' => $validated['shipping_name'],
                    'shipping_phone' => $validated['shipping_phone'],
                    'shipping_address' => $validated['shipping_address'],
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
                Cart::where('user_id', Auth::id())->delete();

                return $order;
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show($id)
    {
        $order = Order::with('items.product.umkm')->where('user_id', Auth::id())->findOrFail($id);

        return view('orders.show', compact('order'));
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
