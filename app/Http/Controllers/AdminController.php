<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Culture;
use App\Models\EventModel;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Tourism;
use App\Models\Umkm;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'umkms' => Umkm::count(),
            'products' => Product::count(),
            'orders' => Order::count(),
            'cultures' => Culture::count(),
            'tourisms' => Tourism::count(),
            'events' => EventModel::count(),
            'total_sales' => Order::where('status', 'completed')->sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'pending_umkms' => Umkm::where('status', 'pending')->count(),
            'unpaid_orders' => Order::where('payment_status', 'unpaid')->count(),
            'verification_orders' => Order::where('payment_status', 'waiting_verification')->count(),
            'paid_orders' => Order::where('payment_status', 'paid')->count(),
            'failed_payments' => Order::where('payment_status', 'failed')->count(),
            'paid_revenue' => Order::where('payment_status', 'paid')->sum('total'),
        ];

        $recent_orders = Order::with('user', 'items')->latest()->limit(10)->get();
        $recent_users = User::latest()->limit(5)->get();
        $pending_umkms = Umkm::where('status', 'pending')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'recent_users', 'pending_umkms'));
    }

    public function umkms()
    {
        $umkms = Umkm::with('user')->latest()->paginate(10);

        return view('admin.umkms', compact('umkms'));
    }

    public function umkmApprove($id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->update(['status' => 'approved']);

        return back()->with('success', 'UMKM '.$umkm->name.' berhasil disetujui.');
    }

    public function umkmReject(Request $req, $id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->update(['status' => 'rejected']);

        return back()->with('success', 'UMKM '.$umkm->name.' ditolak.');
    }

    public function users()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function orders(Request $req)
    {
        $validated = $req->validate([
            'payment_status' => 'nullable|in:unpaid,waiting_verification,paid,failed',
        ]);
        $query = Order::with('user', 'items')->latest();

        if (! empty($validated['payment_status'])) {
            $query->where('payment_status', $validated['payment_status']);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders', compact('orders'));
    }

    public function orderShow($id)
    {
        $order = Order::with(['user', 'items.product', 'items.umkm'])->findOrFail($id);

        return view('admin.order-show', compact('order'));
    }

    public function reviews()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(15);

        return view('admin.reviews', compact('reviews'));
    }

    public function orderStatusUpdate(Request $req, $id)
    {
        $validated = $req->validate(['status' => 'required|in:pending,processing,completed,cancelled']);

        try {
            DB::transaction(function () use ($id, $validated) {
            $order = Order::with('items')->lockForUpdate()->findOrFail($id);

            if (in_array($validated['status'], ['processing', 'completed'], true) && $order->payment_status !== 'paid') {
                throw new \RuntimeException('Pesanan hanya bisa diproses setelah pembayaran lunas.');
            }

            $wasCancelled = $order->status === 'cancelled';
            $willCancel = $validated['status'] === 'cancelled';

            if (! $wasCancelled && $willCancel) {
                foreach ($order->items as $item) {
                    $item->product()->lockForUpdate()->first()?->increment('stock', $item->quantity);
                }
            }

                $order->update(['status' => $validated['status']]);
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function paymentStatusUpdate(Request $req, $id)
    {
        $order = Order::findOrFail($id);
        $validated = $req->validate(['payment_status' => 'required|in:unpaid,waiting_verification,paid,failed']);
        $order->update(['payment_status' => $validated['payment_status']]);
        $order->user->notify(new OrderNotification($order, 'Status pembayaran diperbarui menjadi '.Order::paymentStatusLabel($order->payment_status).'.'));

        return back()->with('success', 'Status pembayaran diperbarui.');
    }

    // ========== CULTURE CRUD ==========
    public function cultures()
    {
        $cultures = Culture::with('category')->latest()->paginate(10);

        return view('admin.cultures', compact('cultures'));
    }

    public function cultureCreate()
    {
        $categories = Category::where('type', 'culture')->get();

        return view('admin.culture-create', compact('categories'));
    }

    public function cultureStore(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cultures,slug',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'history' => 'nullable|string',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($req->hasFile('image')) {
            $path = $req->file('image')->store('cultures', 'public');
            $validated['image'] = $path;
        }
        $validated['is_featured'] = $req->boolean('is_featured');
        Culture::create($validated);

        return redirect()->route('admin.cultures')->with('success', 'Budaya berhasil ditambahkan.');
    }

    public function cultureEdit($id)
    {
        $culture = Culture::findOrFail($id);
        $categories = Category::where('type', 'culture')->get();

        return view('admin.culture-edit', compact('culture', 'categories'));
    }

    public function cultureUpdate(Request $req, $id)
    {
        $culture = Culture::findOrFail($id);
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cultures,slug,'.$id,
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'history' => 'nullable|string',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($req->hasFile('image')) {
            $oldImage = $culture->image;
            $path = $req->file('image')->store('cultures', 'public');
            $validated['image'] = $path;
            if ($oldImage && ! filter_var($oldImage, FILTER_VALIDATE_URL)) Storage::disk('public')->delete($oldImage);
        }
        $validated['is_featured'] = $req->boolean('is_featured');
        $culture->update($validated);

        return redirect()->route('admin.cultures')->with('success', 'Budaya berhasil diperbarui.');
    }

    public function cultureDestroy($id)
    {
        Culture::findOrFail($id)->delete();

        return back()->with('success', 'Budaya berhasil dihapus.');
    }

    // ========== TOURISM CRUD ==========
    public function tourisms()
    {
        $tourisms = Tourism::with('category')->latest()->paginate(10);

        return view('admin.tourisms', compact('tourisms'));
    }

    public function tourismCreate()
    {
        $categories = Category::where('type', 'tourism')->get();

        return view('admin.tourism-create', compact('categories'));
    }

    public function tourismStore(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tourisms,slug',
            'category_id' => 'nullable|exists:categories,id',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'open_time' => 'nullable|date_format:H:i',
            'close_time' => 'nullable|date_format:H:i',
            'ticket_price' => 'nullable|numeric|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($req->hasFile('image')) {
            $path = $req->file('image')->store('tourisms', 'public');
            $validated['image'] = $path;
        }
        $validated['is_featured'] = $req->boolean('is_featured');
        Tourism::create($validated);

        return redirect()->route('admin.tourisms')->with('success', 'Wisata berhasil ditambahkan.');
    }

    public function tourismEdit($id)
    {
        $tourism = Tourism::findOrFail($id);
        $categories = Category::where('type', 'tourism')->get();

        return view('admin.tourism-edit', compact('tourism', 'categories'));
    }

    public function tourismUpdate(Request $req, $id)
    {
        $tourism = Tourism::findOrFail($id);
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tourisms,slug,'.$id,
            'category_id' => 'nullable|exists:categories,id',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'open_time' => 'nullable|date_format:H:i',
            'close_time' => 'nullable|date_format:H:i',
            'ticket_price' => 'nullable|numeric|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($req->hasFile('image')) {
            $oldImage = $tourism->image;
            $path = $req->file('image')->store('tourisms', 'public');
            $validated['image'] = $path;
            if ($oldImage && ! filter_var($oldImage, FILTER_VALIDATE_URL)) Storage::disk('public')->delete($oldImage);
        }
        $validated['is_featured'] = $req->boolean('is_featured');
        $tourism->update($validated);

        return redirect()->route('admin.tourisms')->with('success', 'Wisata berhasil diperbarui.');
    }

    public function tourismDestroy($id)
    {
        Tourism::findOrFail($id)->delete();

        return back()->with('success', 'Wisata berhasil dihapus.');
    }

    // ========== EVENT CRUD ==========
    public function events()
    {
        $events = EventModel::latest()->paginate(10);

        return view('admin.events', compact('events'));
    }

    public function eventCreate()
    {
        return view('admin.event-create');
    }

    public function eventStore(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:events,slug',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_registration_open' => 'nullable|boolean',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        if ($req->hasFile('image')) {
            $path = $req->file('image')->store('events', 'public');
            $validated['image'] = $path;
        }
        $validated['is_registration_open'] = $req->boolean('is_registration_open');
        EventModel::create($validated);

        return redirect()->route('admin.events')->with('success', 'Event berhasil ditambahkan.');
    }

    public function eventEdit($id)
    {
        $event = EventModel::findOrFail($id);

        return view('admin.event-edit', compact('event'));
    }

    public function eventUpdate(Request $req, $id)
    {
        $event = EventModel::findOrFail($id);
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:events,slug,'.$id,
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_registration_open' => 'nullable|boolean',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        if ($req->hasFile('image')) {
            $oldImage = $event->image;
            $path = $req->file('image')->store('events', 'public');
            $validated['image'] = $path;
            if ($oldImage && ! filter_var($oldImage, FILTER_VALIDATE_URL)) Storage::disk('public')->delete($oldImage);
        }
        $validated['is_registration_open'] = $req->boolean('is_registration_open');
        $event->update($validated);

        return redirect()->route('admin.events')->with('success', 'Event berhasil diperbarui.');
    }

    public function eventDestroy($id)
    {
        EventModel::findOrFail($id)->delete();

        return back()->with('success', 'Event berhasil dihapus.');
    }
}
