@extends('layouts.app')
@section('title', 'Премиальные бренды')
@section('content')

@php
    $popularBrands = [
        ['name' => 'Audi', 'query' => 'audi', 'logo' => 'audi'],
        ['name' => 'BMW', 'query' => 'bmw', 'logo' => 'bmw'],
        ['name' => 'Mercedes-Benz', 'query' => 'mercedes-benz', 'logo' => 'mercedes'],
        ['name' => 'Ford', 'query' => 'ford', 'logo' => 'ford'],
        ['name' => 'Toyota', 'query' => 'toyota', 'logo' => 'toyota'],
        ['name' => 'Volkswagen', 'query' => 'volkswagen', 'logo' => 'volkswagen'],
        ['name' => 'Porsche', 'query' => 'porsche', 'logo' => 'porsche'],
        ['name' => 'Nissan', 'query' => 'nissan', 'logo' => 'nissan'],
        ['name' => 'Hyundai', 'query' => 'hyundai', 'logo' => 'hyundai'],
        ['name' => 'Skoda', 'query' => 'skoda', 'logo' => 'skoda'],
        ['name' => 'Peugeot', 'query' => 'peugeot', 'logo' => 'peugeot'],
        ['name' => 'Bentley', 'query' => 'bentley', 'logo' => 'bentley'],
        ['name' => 'Jeep', 'query' => 'jeep', 'logo' => 'jeep'],
    ];
@endphp

<section class="carhut-hero" style="min-height: 40vh; padding: 4rem 0;">
    <div class="carhut-hero-bg"></div>
    <div class="container carhut-hero-inner">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="carhut-hero-title mb-3">Премиальные бренды</h1>
                <p class="carhut-hero-subtitle">
                    Выберите марку и сразу откройте каталог только с автомобилями этого бренда.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="carhut-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="carhut-section-title mb-3">Популярные бренды</h2>
            <p class="text-soft">Нажмите на логотип, чтобы открыть все доступные модели бренда</p>
        </div>

        <div class="row g-4 mb-5">
            @foreach ($popularBrands as $brand)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('catalog', ['brand' => $brand['query']]) }}" class="brand-logo brand-logo-link">
                        <div class="text-center w-100">
                            <div class="brand-logo-mark-wrap">
                                <img
                                    src="https://cdn.simpleicons.org/{{ $brand['logo'] }}/FFFFFF"
                                    alt="{{ $brand['name'] }} logo"
                                    class="brand-logo-mark"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';"
                                >
                                <span class="brand-logo-fallback">{{ strtoupper(substr($brand['name'], 0, 2)) }}</span>
                            </div>
                            <div class="fw-semibold brand-logo-title">{{ $brand['name'] }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center mb-5">
            <h2 class="carhut-section-title mb-3">Популярные модели</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="car-card h-100">
                    <div class="position-relative">
                        <img src="{{ asset('images/cars/bmw-x5-2023.png') }}"
                             class="w-100" alt="BMW" style="height: 220px; object-fit: cover;">
                        <span class="car-card-badge">BMW</span>
                    </div>
                    <div class="p-4">
                        <h5 class="mb-2">BMW X5 2023</h5>
                        <p class="text-soft small mb-3">Премиальный SUV с мощным двигателем и роскошным интерьером.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="car-card-price">от 5 500 000 ₽</div>
                            <a href="{{ route('catalog', ['brand' => 'bmw']) }}" class="btn btn-sm carhut-btn-primary">Смотреть</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="car-card h-100">
                    <div class="position-relative">
                        <img src="{{ asset('images/cars/mercedes-c-class-2023.png') }}"
                             class="w-100" alt="Mercedes" style="height: 220px; object-fit: cover;">
                        <span class="car-card-badge" style="background: var(--accent-gradient);">Mercedes</span>
                    </div>
                    <div class="p-4">
                        <h5 class="mb-2">Mercedes-Benz C-Class 2023</h5>
                        <p class="text-soft small mb-3">Элегантный седан с передовыми технологиями и высоким комфортом.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="car-card-price">от 3 800 000 ₽</div>
                            <a href="{{ route('catalog', ['brand' => 'mercedes-benz']) }}" class="btn btn-sm carhut-btn-primary">Смотреть</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="car-card h-100">
                    <div class="position-relative">
                        <img src="{{ asset('images/cars/audi-q7-2023.png') }}"
                             class="w-100" alt="Audi" style="height: 220px; object-fit: cover;">
                        <span class="car-card-badge" style="background: var(--secondary-gradient);">Audi</span>
                    </div>
                    <div class="p-4">
                        <h5 class="mb-2">Audi Q7 2023</h5>
                        <p class="text-soft small mb-3">Просторный премиальный внедорожник для города и дальних поездок.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="car-card-price">от 6 200 000 ₽</div>
                            <a href="{{ route('catalog', ['brand' => 'audi']) }}" class="btn btn-sm carhut-btn-primary">Смотреть</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
