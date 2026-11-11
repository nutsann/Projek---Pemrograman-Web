<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    private function getApprovedUmkm()
    {
        return Umkm::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->firstOrFail();
    }

    public function dashboard()
    {
        $umkm = Umkm::where('user_id', Auth::id())->first();

        if (! $umkm) {
            return redirect()->route('umkm.setup')
                ->with('info', 'Silakan lengkapi data UMKM Anda terlebih dahulu.');
        }

        if ($umkm->status !== 'approved') {
            return redirect()->route('umkm.setup')
                ->with('error', 'UMKM Anda belum disetujui admin.');
        }

        $stats = [
            'products' => Product::where('umkm_id', $umkm->id)->count(),
            'orders' => OrderItem::where('umkm_id', $umkm->id)
                ->distinct('order_id')->count('order_id'),
            'total_sales' => OrderItem::where('umkm_id', $umkm->id)
                ->sum('subtotal'),
            'pending_orders' => OrderItem::where('umkm_id', $umkm->id)
                ->where('status', 'pending')->count(),
            'processing_orders' => OrderItem::where('umkm_id', $umkm->id)
                ->where('status', 'processing')->count(),
        ];

        $recent_orders = Order::with('items.product')
            ->whereHas('items', fn ($q) => $q->where('umkm_id', $umkm->id))
            ->latest()
            ->limit(5)
            ->get();

        $products = Product::where('umkm_id', $umkm->id)
            ->latest()->paginate(10);

        return view('umkm.dashboard', compact(
            'umkm',
            'stats',
            'recent_orders',
            'products'
        ));
    }

    public function showSetup()
    {
        $umkm = Umkm::where('user_id', Auth::id())->first();

        if ($umkm) {
            if ($umkm->status === 'approved') {
                return redirect()->route('umkm.dashboard');
            }

            return view('umkm.setup', compact('umkm'));
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
            $validated['logo'] = $req->file('logo')
                ->store('umkm_logos', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        Umkm::create($validated);

        return redirect()->route('umkm.dashboard')
            ->with('success', 'Data UMKM berhasil disimpan. Menunggu approval admin.');
    }

    public function products()
    {
        $umkm = $this->getApprovedUmkm();

        $products = Product::where('umkm_id', $umkm->id)
            ->latest()->paginate(10);

        return view('umkm.products', compact('products', 'umkm'));
    }

    public function productCreate()
    {
        $this->getApprovedUmkm();

        $categories = Category::where('type', 'product')->get();

        return view('umkm.product-create', compact('categories'));
    }

    public function productStore(Request $req)
    {
        $umkm = $this->getApprovedUmkm();

        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => [
                'required',
                'exists:categories,id,type,product',
            ],
            'status' => 'required|in:active,inactive',
        ]);

        if ($req->hasFile('image')) {
            $validated['image'] = $req->file('image')
                ->store('products', 'public');
        }

        $validated['umkm_id'] = $umkm->id;

        Product::create($validated);

        return redirect()->route('umkm.products')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function productEdit($id)
    {
        $umkm = $this->getApprovedUmkm();

        $product = Product::where('umkm_id', $umkm->id)
            ->findOrFail($id);

        $categories = Category::where('type', 'product')->get();

        return view('umkm.product-edit', compact('product', 'categories'));
    }

    public function productUpdate(Request $req, $id)
    {
        $umkm = $this->getApprovedUmkm();

        $product = Product::where('umkm_id', $umkm->id)
            ->findOrFail($id);

        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,'.$id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => [
                'required',
                'exists:categories,id,type,product',
            ],
            'status' => 'required|in:active,inactive',
        ]);

        if ($req->hasFile('image')) {
            $oldImage = $product->image;

            $validated['image'] = $req->file('image')
                ->store('products', 'public');

            if ($oldImage && ! filter_var($oldImage, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        $product->update($validated);

        return redirect()->route('umkm.products')
            ->with('success', 'Produk berhasil diupdate.');
    }

    public function productDestroy($id)
    {
        $umkm = $this->getApprovedUmkm();

        $product = Product::where('umkm_id', $umkm->id)
            ->findOrFail($id);

        $product->delete();

        return redirect()->route('umkm.products')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function orders()
    {
        $umkm = $this->getApprovedUmkm();

        $orders = Order::with([
            'items' => fn ($q) => $q->where('umkm_id', $umkm->id)
                ->with('product'),
        ])
            ->whereHas('items', fn ($q) => $q->where('umkm_id', $umkm->id))
            ->latest()
            ->paginate(10);

        return view('umkm.orders', compact('orders', 'umkm'));
    }

    public function orderUpdate(Request $req, OrderItem $orderItem)
    {
        $umkm = $this->getApprovedUmkm();

        $validated = $req->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        DB::transaction(function () use ($orderItem, $umkm, $validated) {
            $item = OrderItem::where('umkm_id', $umkm->id)
                ->lockForUpdate()
                ->findOrFail($orderItem->id);

            $order = Order::lockForUpdate()
                ->findOrFail($item->order_id);

            if ($order->status === 'cancelled') {
                abort(403, 'Pesanan sudah dibatalkan.');
            }

            if ($item->status === 'cancelled') {
                abort(403, 'Item pesanan sudah dibatalkan.');
            }

            $item->update([
                'status' => $validated['status'],
            ]);

            $statuses = $order->items()->pluck('status');

            if ($statuses->every(fn ($status) => $status === 'cancelled')) {
                $mainStatus = 'cancelled';
            } elseif ($statuses->every(
                fn ($status) => in_array($status, ['completed', 'cancelled'], true)
            )) {
                $mainStatus = 'completed';
            } elseif ($statuses->contains('processing')) {
                $mainStatus = 'processing';
            } else {
                $mainStatus = 'pending';
            }

            $order->update([
                'status' => $mainStatus,
            ]);
        });

        return back()->with(
            'success',
            'Status item pesanan berhasil diperbarui.'
        );
    }

}
