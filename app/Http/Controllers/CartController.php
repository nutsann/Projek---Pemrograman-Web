<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product.umkm')->where('user_id', Auth::id())->get();
        $subtotal = $carts->sum(fn ($c) => $c->product->price * $c->quantity);

        return view('cart.index', compact('carts', 'subtotal'));
    }

    public function add(Request $req, $productId)
    {
        $product = Product::findOrFail($productId);
        $qty = (int) $req->input('quantity', 1);
        if ($qty < 1) {
            return back()->with('error', 'Jumlah minimal 1.');
        }
        if ($product->stock < $qty) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }
        $cart = Cart::where('user_id', Auth::id())->where('product_id', $productId)->first();
        if ($cart) {
            $newQty = $cart->quantity + $qty;
            if ($product->stock < $newQty) {
                return back()->with('error', 'Jumlah melebihi stok tersedia.');
            }
            $cart->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $qty,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $req, $id)
    {
        $cart = Cart::with('product')->where('user_id', Auth::id())->findOrFail($id);
        $qty = (int) $req->input('quantity');
        if ($qty < 1) {
            return back()->with('error', 'Jumlah minimal 1.');
        }
        if ($cart->product->stock < $qty) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }
        $cart->update(['quantity' => $qty]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
