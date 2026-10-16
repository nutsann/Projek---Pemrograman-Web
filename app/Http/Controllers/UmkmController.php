<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmController extends Controller
{
    public function dashboard()
    {
        $umkm = Umkm::where('user_id', Auth::id())->first();
        if (! $umkm) {
            return redirect()->route('umkm.setup')->with('info', 'Silakan lengkapi data UMKM Anda terlebih dahulu.');
        }
        $stats = [
            'products' => Product::where('umkm_id', $umkm->id)->count(),
            'orders' => OrderItem::where('umkm_id', $umkm->id)->distinct('order_id')->count('order_id'),
            'total_sales' => OrderItem::where('umkm_id', $umkm->id)->sum('subtotal'),
            'pending_orders' => Order::whereHas('items', fn ($q) => $q->where('umkm_id', $umkm->id))->where('status', 'pending')->count(),
            'processing_orders' => Order::whereHas('items', fn ($q) => $q->where('umkm_id', $umkm->id))->where('status', 'processing')->count(),
        ];
        $recent_orders = Order::with('items.product')
            ->whereHas('items', fn ($q) => $q->where('umkm_id', $umkm->id))
            ->latest()
            ->limit(5)
            ->get();
        $products = Product::where('umkm_id', $umkm->id)->latest()->paginate(10);

        return view('umkm.dashboard', compact('umkm', 'stats', 'recent_orders', 'products'));
    }

    public function showSetup()
    {
        $umkm = Umkm::where('user_id', Auth::id())->first();
        if ($umkm) {
            return redirect()->route('umkm.dashboard');
        }

        return view('umkm.setup');
    }

    public function storeSetup(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:umkms,slug',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($req->hasFile('logo')) {
            $path = $req->file('logo')->store('umkm_logos', 'public');
            $validated['logo'] = $path;
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        Umkm::create($validated);

        return redirect()->route('umkm.dashboard')->with('success', 'Data UMKM berhasil disimpan. Menunggu approval admin.');
    }

    public function products()
    {
        $umkm = Umkm::where('user_id', Auth::id())->first();
        if (! $umkm) {
            return redirect()->route('umkm.setup')->with('error', 'Setup UMKM dulu.');
        }
        $products = Product::where('umkm_id', $umkm->id)->latest()->paginate(10);

        return view('umkm.products', compact('products', 'umkm'));
    }

    public function productCreate()
    {
        $categories = Category::where('type', 'product')->get();

        return view('umkm.product-create', compact('categories'));
    }

    public function productStore(Request $req)
    {
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($req->hasFile('image')) {
            $path = $req->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $validated['umkm_id'] = $umkm->id;
        Product::create($validated);

        return redirect()->route('umkm.products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function productEdit($id)
    {
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();
        $product = Product::where('umkm_id', $umkm->id)->findOrFail($id);
        $categories = Category::where('type', 'product')->get();

        return view('umkm.product-edit', compact('product', 'categories'));
    }

    public function productUpdate(Request $req, $id)
    {
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();
        $product = Product::where('umkm_id', $umkm->id)->findOrFail($id);
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,'.$id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($req->hasFile('image')) {
            $path = $req->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('umkm.products')->with('success', 'Produk berhasil diupdate.');
    }

    public function productDestroy($id)
    {
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();
        Product::where('umkm_id', $umkm->id)->where('id', $id)->delete();

        return redirect()->route('umkm.products')->with('success', 'Produk berhasil dihapus.');
    }

    public function orders()
    {
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();
        $orders = Order::with('items.product.umkm')
            ->whereHas('items', fn ($q) => $q->where('umkm_id', $umkm->id))
            ->latest()
            ->paginate(10);

        return view('umkm.orders', compact('orders', 'umkm'));
    }

    public function orderUpdate(Request $req, OrderItem $orderItem)
    {
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();
        if ($orderItem->umkm_id !== $umkm->id) {
            abort(403);
        }
        $validated = $req->validate(['status' => 'required|in:pending,processing,completed,cancelled']);
        $orderItem->order->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
