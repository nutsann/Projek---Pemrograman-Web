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
        $query = Culture::query();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
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
        $query = Tourism::query();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $query->orderByDesc('is_featured')->orderByDesc('created_at');

        return view('tourisms.index', ['tourisms' => $query->paginate(12)->withQueryString()]);
    }

    public function tourismDetail($slug)
    {
        return view('tourisms.detail', ['tourism' => Tourism::where('slug', $slug)->firstOrFail()]);
    }

    public function events()
    {
        return view('events.index', ['events' => EventModel::paginate(12)]);
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
