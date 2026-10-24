<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Culture;
use App\Models\EventModel;
use App\Models\Product;
use App\Models\Tourism;
use App\Models\Umkm;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function quickSearch(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $like = '%'.$query.'%';

        if ($query === '') {
            $cultures = Culture::where('is_featured', true)->latest()->limit(3)->get();
            $tourisms = Tourism::where('is_featured', true)->latest()->limit(3)->get();
            $products = Product::where('is_featured', true)->where('status', 'active')->latest()->limit(3)->get();
            $events = EventModel::where('status', '!=', 'completed')->orderBy('start_date')->limit(3)->get();
        } else {
            $cultures = Culture::where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('short_description', 'like', $like);
            })->limit(5)->get();
            $tourisms = Tourism::where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('short_description', 'like', $like)->orWhere('location', 'like', $like);
            })->limit(5)->get();
            $products = Product::where('status', 'active')->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('description', 'like', $like);
            })->limit(5)->get();
            $events = EventModel::where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('description', 'like', $like)->orWhere('location', 'like', $like);
            })->limit(5)->get();
        }

        return response()->json([
            'cultures' => $cultures->map(fn ($item) => ['name' => $item->name, 'url' => route('cultures.detail', $item->slug), 'image' => $item->image]),
            'tourisms' => $tourisms->map(fn ($item) => ['name' => $item->name, 'url' => route('tourisms.detail', $item->slug), 'image' => $item->image]),
            'products' => $products->map(fn ($item) => ['name' => $item->name, 'url' => route('products.detail', $item->slug), 'image' => $item->image, 'price' => 'Rp '.number_format($item->price, 0, ',', '.')]),
            'events' => $events->map(fn ($item) => ['name' => $item->name, 'url' => route('events.detail', $item->slug), 'image' => $item->image]),
        ]);
    }

    public function index()
    {
        return view('home.index', [
            'featured_cultures' => Culture::where('is_featured', true)->limit(6)->get(),
            'featured_tourisms' => Tourism::where('is_featured', true)->limit(6)->get(),
            'featured_events' => EventModel::where('status', '!=', 'completed')->limit(6)->get(),
            'featured_products' => Product::where('is_featured', true)->where('status', 'active')->limit(6)->get(),
            'umkms' => Umkm::where('status', 'approved')->limit(6)->get(),
        ]);
    }

    public function cultures(Request $request)
    {
        $query = Culture::with('category');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->category !== 'semua') {
            $cat = $request->category;
            $query->whereHas('category', fn ($q) => $q->where('slug', $cat)->orWhere('name', 'like', "%{$cat}%"));
        }

        $query->orderByDesc('is_featured')
            ->when($request->sort === 'oldest', fn ($builder) => $builder->orderBy('created_at'))
            ->when($request->sort !== 'oldest', fn ($builder) => $builder->orderByDesc('created_at'));

        return view('cultures.index', ['cultures' => $query->paginate(12)->withQueryString()]);
    }

    public function cultureDetail($slug)
    {
        return view('cultures.detail', ['culture' => Culture::where('slug', $slug)->firstOrFail()]);
    }

    public function tourisms(Request $request)
    {
        $query = Tourism::with('category');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->category !== 'semua') {
            $cat = $request->category;
            $query->where(function ($q) use ($cat) {
                $q->whereHas('category', fn ($c) => $c->where('slug', $cat)->orWhere('name', 'like', "%{$cat}%"))
                  ->orWhere('name', 'like', "%{$cat}%")
                  ->orWhere('short_description', 'like', "%{$cat}%");
            });
        }

        $query->orderByDesc('is_featured')->orderByDesc('created_at');

        return view('tourisms.index', ['tourisms' => $query->paginate(12)->withQueryString()]);
    }

    public function tourismDetail($slug)
    {
        return view('tourisms.detail', ['tourism' => Tourism::where('slug', $slug)->firstOrFail()]);
    }

    public function events(Request $request)
    {
        $query = EventModel::query();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->category !== 'semua') {
            $cat = $request->category;
            $query->where(function ($builder) use ($cat) {
                $builder->where('name', 'like', "%{$cat}%")
                    ->orWhere('description', 'like', "%{$cat}%");
            });
        }

        $query->orderBy('start_date');

        return view('events.index', ['events' => $query->paginate(12)->withQueryString()]);
    }

    public function eventDetail($slug)
    {
        return view('events.detail', ['event' => EventModel::where('slug', $slug)->firstOrFail()]);
    }

    public function marketplace(Request $req)
    {
        $query = Product::with(['umkm', 'category'])->where('status', 'active');
        if ($req->filled('search')) {
            $search = $req->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%');
            });
        }
        if ($req->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $req->category));
        }
        $query->when($req->sort === 'price_asc', fn ($q) => $q->orderBy('price'));
        $query->when($req->sort === 'price_desc', fn ($q) => $q->orderByDesc('price'));
        $query->when($req->sort === 'rating', fn ($q) => $q->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating'));
        $categories = Category::where('type', 'product')->get();

        return view('marketplace.index', [
            'products' => $query->latest()->paginate(12)->withQueryString(),
            'categories' => $categories,
        ]);
    }

    public function productDetail($slug)
    {
        $product = Product::with(['umkm', 'category', 'reviews.user'])->where('slug', $slug)->firstOrFail();

        return view('marketplace.detail', compact('product'));
    }

    public function map()
    {
        return view('map.index', [
            'cultures' => Culture::whereNotNull('latitude')->get(),
            'tourisms' => Tourism::whereNotNull('latitude')->get(),
            'umkms' => Umkm::where('status','approved')->whereNotNull('latitude')->get(),
        ]);
    }
}
