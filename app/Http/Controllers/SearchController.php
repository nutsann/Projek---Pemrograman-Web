<?php

namespace App\Http\Controllers;

use App\Models\Culture;
use App\Models\EventModel;
use App\Models\Product;
use App\Models\Tourism;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type', 'all');

        if (empty($query)) {
            return redirect()->route('home');
        }

        $results = [];
        $pagination = null;

        $searchQuery = strtoupper($query);

        if ($type === 'all' || $type === 'cultures') {
            $cultures = Culture::whereRaw('UPPER(name) LIKE ?', ["%{$searchQuery}%"])
                ->orWhereRaw('UPPER(slug) LIKE ?', ["%{$searchQuery}%"])
                ->with('category')
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();

            if ($cultures->isNotEmpty()) {
                $results['cultures'] = $cultures;
            }
        }

        if ($type === 'all' || $type === 'tourisms') {
            $tourisms = Tourism::whereRaw('UPPER(name) LIKE ?', ["%{$searchQuery}%"])
                ->orWhereRaw('UPPER(slug) LIKE ?', ["%{$searchQuery}%"])
                ->with('category')
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();

            if ($tourisms->isNotEmpty()) {
                $results['tourisms'] = $tourisms;
            }
        }

        if ($type === 'all' || $type === 'events') {
            $events = EventModel::whereRaw('UPPER(name) LIKE ?', ["%{$searchQuery}%"])
                ->orWhereRaw('UPPER(slug) LIKE ?', ["%{$searchQuery}%"])
                ->orderBy('start_date', 'asc')
                ->limit(8)
                ->get();

            if ($events->isNotEmpty()) {
                $results['events'] = $events;
            }
        }

        if ($type === 'all' || $type === 'products') {
            $products = Product::whereRaw('UPPER(name) LIKE ?', ["%{$searchQuery}%"])
                ->orWhereRaw('UPPER(slug) LIKE ?', ["%{$searchQuery}%"])
                ->orWhereRaw('UPPER(description) LIKE ?', ["%{$searchQuery}%"])
                ->with(['umkm', 'category', 'reviews' => fn ($q) => $q->latest()])
                ->where('status', 'active')
                ->orderBy('is_featured', 'desc')
                ->orderBy(DB::raw('COALESCE(AVG(reviews.rating), 0)'), 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(12)
                ->get();

            if ($products->isNotEmpty()) {
                $results['products'] = $products;
            }
        }

        if ($type === 'all' || $type === 'umkms') {
            $umkms = Umkm::whereRaw('UPPER(name) LIKE ?', ["%{$searchQuery}%"])
                ->orWhereRaw('UPPER(slug) LIKE ?', ["%{$searchQuery}%"])
                ->with(['user'])
                ->where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();

            if ($umkms->isNotEmpty()) {
                $results['umkms'] = $umkms;
            }
        }

        if (empty($results)) {
            $results['no_results'] = true;
        }

        return view('search.results', compact('results', 'query', 'type'));
    }

    public function cultures(Request $request)
    {
        $query = $request->input('q', '');

        return $this->searchByType($query, 'cultures');
    }

    public function tourisms(Request $request)
    {
        $query = $request->input('q', '');

        return $this->searchByType($query, 'tourisms');
    }

    public function products(Request $request)
    {
        $query = $request->input('q', '');

        return $this->searchByType($query, 'products');
    }

    public function umkms(Request $request)
    {
        $query = $request->input('q', '');

        return $this->searchByType($query, 'umkms');
    }

    protected function searchByType($query, $type)
    {
        $model = match ($type) {
            'cultures' => Culture::class,
            'tourisms' => Tourism::class,
            'products' => Product::class,
            'umkms' => Umkm::class,
            'events' => EventModel::class,
        };

        $searchQuery = strtoupper($query);

        $results = $model::whereRaw('UPPER(name) LIKE ?', ["%{$searchQuery}%"])
            ->orWhereRaw('UPPER(slug) LIKE ?', ["%{$searchQuery}%"])
            ->when($type === 'products', fn ($q) => $q->where('status', 'active'))
            ->when($type === 'umkms', fn ($q) => $q->where('status', 'approved'))
            ->with($this->getRelation($type))
            ->orderBy('is_featured', 'desc')
            ->orWhere('created_at', 'desc')
            ->paginate(12);

        $view = match ($type) {
            'cultures' => 'cultures.index',
            'tourisms' => 'tourisms.index',
            'products' => 'marketplace.index',
            'umkms' => 'umkm.dashboard',
            'events' => 'events.index',
        };

        return view($view, [
            $this->getVariableName($type) => $results,
            'query' => $query,
        ]);
    }

    protected function getRelation($type): string
    {
        return match ($type) {
            'cultures' => 'category',
            'tourisms' => 'category',
            'products' => 'umkm.category.reviews',
            'umkms' => 'user',
            'events' => 'registrations',
        };
    }

    protected function getVariableName($type): string
    {
        return match ($type) {
            'cultures' => 'cultures',
            'tourisms' => 'tourisms',
            'products' => 'products',
            'umkms' => 'umkms',
            'events' => 'events',
        };
    }
}
