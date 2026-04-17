@extends('layouts.app')
@section('title', 'Каталог автомобилей')
@section('content')

@php
    $catalogSlides = [
        [
            'image' => asset('images/cars/premium-suv-bmw-x5.png'),
            'kicker' => 'Премиальные SUV',
            'title' => 'Подборка кроссоверов и внедорожников для города и трассы',
            'text' => 'BMW X5, Audi Q7, Mercedes GLE, Lexus RX и другие модели с более живой фотоподачей прямо в каталоге.',
        ],
        [
            'image' => asset('images/cars/electric-sedan.png'),
            'kicker' => 'Электромобили',
            'title' => 'Современные электрокары с чистой визуальной подачей',
            'text' => 'Tesla, EQS, Taycan, IONIQ и другие электромобили теперь выглядят в каталоге ближе к своим названиям.',
        ],
        [
            'image' => asset('images/cars/sports-coupe.png'),
            'kicker' => 'Спортивные модели',
            'title' => 'Эмоциональные купе и мощные седаны в отдельной витрине',
            'text' => 'Porsche, Mustang, Camaro, GT-R и другие быстрые автомобили получили более подходящие локальные изображения.',
        ],
    ];
@endphp

<section class="carhut-section py-5">
    <div class="container">
        <div class="catalog-topbar">
            <div>
                <p class="catalog-kicker mb-2">CarHut Collection</p>
                <h1 class="catalog-title mb-2">Каталог автомобилей</h1>
                <p class="catalog-subtitle mb-0">Подобрали более понятные локальные изображения и освежили верхний блок каталога.</p>
            </div>
            @auth
                <div class="catalog-actions">
                    <button type="button" class="quick-action-item" onclick="showComparePanel()">
                        <span class="quick-action-icon">📊</span>
                        <span>Сравнить</span>
                    </button>
                    <button type="button" class="quick-action-item" onclick="shareCatalog()">
                        <span class="quick-action-icon">📤</span>
                        <span>Поделиться</span>
                    </button>
                </div>
            @endauth
        </div>

        <div id="catalogShowcase" class="carousel slide catalog-showcase mb-4" data-bs-ride="carousel">
            <div class="carousel-indicators catalog-showcase-indicators">
                @foreach ($catalogSlides as $index => $slide)
                    <button type="button"
                            data-bs-target="#catalogShowcase"
                            data-bs-slide-to="{{ $index }}"
                            class="{{ $index === 0 ? 'active' : '' }}"
                            aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-label="Слайд {{ $index + 1 }}"></button>
                @endforeach
            </div>

            <div class="carousel-inner">
                @foreach ($catalogSlides as $index => $slide)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="catalog-showcase-card">
                            <div class="catalog-showcase-copy">
                                <p class="catalog-showcase-kicker">{{ $slide['kicker'] }}</p>
                                <h2 class="catalog-showcase-title">{{ $slide['title'] }}</h2>
                                <p class="catalog-showcase-text">{{ $slide['text'] }}</p>
                                <div class="catalog-showcase-stats">
                                    <div class="catalog-showcase-stat">
                                        <strong>{{ $bbs->total() }}</strong>
                                        <span>объявлений</span>
                                    </div>
                                    <div class="catalog-showcase-stat">
                                        <strong>{{ $bbs->count() }}</strong>
                                        <span>на странице</span>
                                    </div>
                                    <div class="catalog-showcase-stat">
                                        <strong>Local</strong>
                                        <span>изображения</span>
                                    </div>
                                </div>
                            </div>
                            <div class="catalog-showcase-media">
                                <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="catalog-showcase-image">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev catalog-showcase-control" type="button" data-bs-target="#catalogShowcase" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Назад</span>
            </button>
            <button class="carousel-control-next catalog-showcase-control" type="button" data-bs-target="#catalogShowcase" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Вперед</span>
            </button>
        </div>

        <div class="catalog-filters">
            <form method="GET" action="{{ route('catalog') }}" id="catalog-filter-form">
                @if(request('brand'))
                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                    <div class="mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <span class="car-card-tag">Бренд: {{ request('brand') }}</span>
                        <a href="{{ route('catalog', request()->except('brand')) }}" class="btn btn-sm btn-outline-light">Сбросить бренд</a>
                    </div>
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Поиск по названию автомобиля..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <div class="custom-dropdown">
                            <select name="price_filter" id="price_filter">
                                <option value="">Все цены</option>
                                <option value="0-500000" {{ request('price_filter') == '0-500000' ? 'selected' : '' }}>До 500 000 ₽</option>
                                <option value="500000-1000000" {{ request('price_filter') == '500000-1000000' ? 'selected' : '' }}>500 000 - 1 000 000 ₽</option>
                                <option value="1000000-2000000" {{ request('price_filter') == '1000000-2000000' ? 'selected' : '' }}>1 000 000 - 2 000 000 ₽</option>
                                <option value="2000000+" {{ request('price_filter') == '2000000+' ? 'selected' : '' }}>От 2 000 000 ₽</option>
                            </select>
                            <div class="custom-dropdown-select">{{ request('price_filter') ? 'Фильтр по цене' : 'Все цены' }}</div>
                            <div class="custom-dropdown-menu"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-dropdown">
                            <select name="sort" id="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>По дате: новое</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>По цене: дешевле</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>По цене: дороже</option>
                            </select>
                            <div class="custom-dropdown-select">
                                @if(request('sort') == 'price_asc')
                                    По цене: дешевле
                                @elseif(request('sort') == 'price_desc')
                                    По цене: дороже
                                @else
                                    По дате: новое
                                @endif
                            </div>
                            <div class="custom-dropdown-menu"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if ($bbs->count())
            <div class="row g-4">
                @foreach ($bbs as $bb)
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="car-card catalog-car-card h-100 d-flex flex-column">
                            <div class="position-relative">
                                <img src="{{ $bb->image_url }}"
                                     class="w-100"
                                     alt="{{ $bb->title }}"
                                     style="height: 248px; object-fit: cover;"
                                     onerror="this.src='{{ asset('images/cars/premium-suv-bmw-x5.png') }}'">
                                <span class="car-card-badge">В наличии</span>
                            </div>
                            <div class="p-4 d-flex flex-column h-100">
                                <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                                    <span class="car-card-tag">{{ $bb->brand_name }}</span>
                                    <span class="car-card-meta">#{{ $bb->id }}</span>
                                </div>
                                <h5>{{ $bb->title }}</h5>
                                <p class="text-muted small flex-grow-1">{{ $bb->short_description }}</p>
                                <div class="catalog-card-footer mt-auto">
                                    <div class="car-card-price">{{ number_format($bb->price, 0, ',', ' ') }} ₽</div>
                                    <a href="{{ route('detail', ['bb' => $bb->id]) }}" class="btn btn-sm carhut-btn-primary rounded-pill px-3">
                                        Подробнее
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="catalog-pagination">
                <div class="pagination-wrapper">
                    {{ $bbs->links() }}
                </div>
            </div>
        @else
            <div class="text-center text-muted py-5">
                <p class="fs-4">Пока нет объявлений</p>
                <p>Будьте первым, кто добавит автомобиль в каталог.</p>
            </div>
        @endif
    </div>
</section>

@auth
<script>
    function showComparePanel() {
        const compareList = JSON.parse(localStorage.getItem('compareList') || '[]');

        if (compareList.length === 0) {
            alert('Список сравнения пуст. Добавьте объявления на странице автомобиля.');
            return;
        }

        alert('В списке сравнения сейчас ' + compareList.length + ' объявлений.');
    }

    function shareCatalog() {
        const url = window.location.href;

        if (navigator.share) {
            navigator.share({
                title: 'Каталог автомобилей CarHut',
                text: 'Посмотрите каталог автомобилей на CarHut',
                url: url
            }).catch(() => {});

            return;
        }

        navigator.clipboard.writeText(url).then(() => {
            alert('Ссылка на каталог скопирована в буфер обмена.');
        }).catch(() => {
            alert('Не удалось скопировать ссылку автоматически.');
        });
    }
</script>
@endauth

@endsection
