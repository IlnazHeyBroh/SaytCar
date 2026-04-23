<?php

namespace App\Http\Controllers;

use App\Models\Bb;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class BbsController extends Controller
{
    public function index()
    {
        $query = Bb::with('category')->approved();

        if (request()->filled('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        if (request()->filled('price_max')) {
            $query->where('price', '<=', request('price_max'));
        }

        $sort = request('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        return view('index', [
            'bbs' => $query->take(6)->get(),
        ]);
    }

    public function detail($bb)
    {
        $bbModel = Bb::with('category', 'user')->find($bb);
        if (!$bbModel) {
            abort(404);
        }

        $user = request()->user();
        $canViewUnapproved = $user && ($user->isAdmin() || $user->id === $bbModel->user_id);

        if ($bbModel->status !== Bb::STATUS_APPROVED && !$canViewUnapproved) {
            abort(404);
        }

        return view('detail', [
            'bb' => $bbModel,
            'isFavorite' => $user ? $user->hasFavorited($bbModel) : false,
        ]);
    }

    public function catalog()
    {
        $query = Bb::with('category')->approved();
        $categories = Category::orderBy('name')->get();

        $brandFilter = trim((string) request('brand', ''));
        if ($brandFilter !== '') {
            $keywords = $this->brandKeywords($brandFilter);
            $query->where(function ($builder) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $builder->orWhere('title', 'like', '%' . $keyword . '%')
                        ->orWhere('brand', 'like', '%' . $keyword . '%');
                }
            });
        }

        if (request()->filled('search')) {
            $query->where(function ($builder) {
                $builder->where('title', 'like', '%' . request('search') . '%')
                    ->orWhere('brand', 'like', '%' . request('search') . '%');
            });
        }

        $categoryFilter = trim((string) request('category', ''));
        if ($categoryFilter !== '') {
            $query->whereHas('category', function ($builder) use ($categoryFilter) {
                $builder->where('slug', $categoryFilter);
            });
        }

        if (request()->has('price_filter')) {
            $priceFilter = request('price_filter');
            switch ($priceFilter) {
                case '0-500000':
                    $query->where('price', '<=', 500000);
                    break;
                case '500000-1000000':
                    $query->whereBetween('price', [500000, 1000000]);
                    break;
                case '1000000-2000000':
                    $query->whereBetween('price', [1000000, 2000000]);
                    break;
                case '2000000+':
                    $query->where('price', '>=', 2000000);
                    break;
            }
        }

        $sort = request('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        return view('catalog', [
            'bbs' => $query->paginate(12)->withQueryString(),
            'categories' => $categories,
        ]);
    }

    private function brandKeywords(string $brand): array
    {
        $normalized = mb_strtolower(trim($brand));

        $map = [
            'audi' => ['audi'],
            'bmw' => ['bmw'],
            'mercedes' => ['mercedes'],
            'mercedes-benz' => ['mercedes'],
            'ford' => ['ford'],
            'toyota' => ['toyota'],
            'volkswagen' => ['volkswagen'],
            'vw' => ['volkswagen'],
            'porsche' => ['porsche'],
            'nissan' => ['nissan'],
            'hyundai' => ['hyundai'],
            'peugeot' => ['peugeot'],
            'bentley' => ['bentley'],
            'jeep' => ['jeep'],
        ];

        return $map[$normalized] ?? [$brand];
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function blog()
    {
        $blogPosts = [
            [
                'id' => 1,
                'title' => 'BMW X5 2024: обзор и впечатления',
                'category' => 'Обзор',
                'date' => '22 ноября 2024',
                'image' => asset('images/cars/bmw-x5-2023.png'),
                'badge' => 'Новое',
                'badgeStyle' => '',
            ],
            [
                'id' => 2,
                'title' => '10 способов сэкономить на покупке автомобиля',
                'category' => 'Советы',
                'date' => '20 ноября 2024',
                'image' => asset('images/cars/executive-sedan.png'),
                'badge' => 'Популярное',
                'badgeStyle' => 'background: var(--accent-gradient);',
            ],
            [
                'id' => 3,
                'title' => 'Будущее за электромобилями: что нужно знать',
                'category' => 'Электрические',
                'date' => '18 ноября 2024',
                'image' => asset('images/cars/tesla-model-s-2023.png'),
                'badge' => 'Тренд',
                'badgeStyle' => 'background: var(--warning-gradient);',
            ],
            [
                'id' => 4,
                'title' => 'Как быстро продать автомобиль: пошаговая инструкция',
                'category' => 'Продажа',
                'date' => '15 ноября 2024',
                'image' => asset('images/cars/ford-mondeo-2023.png'),
                'badge' => null,
                'badgeStyle' => '',
            ],
            [
                'id' => 5,
                'title' => 'Автокредит: как выбрать лучшие условия',
                'category' => 'Финансы',
                'date' => '12 ноября 2024',
                'image' => asset('images/cars/mercedes-e-class-2023.png'),
                'badge' => null,
                'badgeStyle' => '',
            ],
            [
                'id' => 6,
                'title' => 'Регулярное обслуживание: экономия на ремонте',
                'category' => 'Обслуживание',
                'date' => '10 ноября 2024',
                'image' => asset('images/cars/toyota-camry-2023.png'),
                'badge' => null,
                'badgeStyle' => '',
            ],
        ];

        $currentPage = request()->get('page', 1);
        $perPage = 6;
        $items = collect($blogPosts);
        $currentItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginator = new LengthAwarePaginator(
            $currentItems,
            $items->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('blog', ['blogPosts' => $paginator]);
    }

    public function sell()
    {
        return view('sell');
    }

    public function calculator()
    {
        return view('calculator');
    }

    public function brands()
    {
        return view('brands');
    }

    public function team()
    {
        return view('team');
    }
}
