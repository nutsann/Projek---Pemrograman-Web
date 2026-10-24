<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($orderId)
    {
        $order = Order::with('items.product')->where('user_id', Auth::id())->findOrFail($orderId);
        if ($order->status !== 'completed') {
            return redirect()->route('orders.show', $orderId)->with('error', 'Review hanya dapat dibuat setelah pesanan selesai.');
        }

        return view('reviews.create', compact('order'));
    }

    public function store(Request $req, $orderId)
    {
        $order = Order::with('items')->where('user_id', Auth::id())->findOrFail($orderId);
        if ($order->status !== 'completed') {
            return back()->with('error', 'Review hanya dapat dikirim setelah pesanan selesai.');
        }
        $validated = $req->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if (! $order->items->contains('product_id', $validated['product_id'])) {
            return back()->with('error', 'Produk tidak termasuk dalam pesanan ini.');
        }
        if (Review::where('user_id', Auth::id())->where('product_id', $validated['product_id'])->where('order_id', $orderId)->exists()) {
            return back()->with('error', 'Anda sudah memberikan review untuk produk ini pada pesanan tersebut.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'order_id' => $orderId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()->route('orders.show', $orderId)->with('success', 'Review berhasil dikirim.');
    }

    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        $reviews = Review::with('user')->where('product_id', $productId)->latest()->paginate(5);

        return view('reviews.index', compact('product', 'reviews'));
    }
}
