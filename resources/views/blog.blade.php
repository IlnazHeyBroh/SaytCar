@extends('layouts.app')
@section('title', 'Блог')
@section('content')

<section class="carhut-hero" style="min-height: 40vh; padding: 4rem 0;">
    <div class="carhut-hero-bg"></div>
    <div class="container carhut-hero-inner">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="carhut-hero-title mb-3">Блог CarHut</h1>
                <p class="carhut-hero-subtitle">
                    Полезные статьи, обзоры автомобилей, советы по покупке и продаже
                </p>
            </div>
        </div>
    </div>
</section>

<section class="carhut-section">
    <div class="container">
        <div class="row g-4">
            @if($blogPosts->currentPage() == 1)
                <!-- Featured Post - только на первой странице -->
                <div class="col-12">
                    <article class="blog-card card-premium overflow-hidden">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <img src="{{ asset('images/cars/bmw-x5-2023.png') }}" 
                                     class="w-100 h-100" style="object-fit: cover; min-height: 400px;" alt="Featured">
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="p-4 p-md-5">
                                    <span class="carhut-chip mb-3">Главная статья</span>
                                    <h2 class="h3 mb-3">Как выбрать идеальный автомобиль: полное руководство 2024</h2>
                                    <p class="text-soft mb-4">
                                        Подробное руководство по выбору автомобиля: от определения бюджета до проверки технического состояния. 
                                        Узнайте, на что обратить внимание при покупке нового или подержанного авто.
                                    </p>
                                    <div class="d-flex align-items-center gap-3 mb-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">👤</div>
                                            <div>
                                                <div class="small fw-semibold">Администратор</div>
                                                <div class="small text-soft">23 ноября 2024</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn carhut-btn-primary">Читать далее</a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @endif

            <!-- Blog Posts Grid -->
            @foreach($blogPosts as $post)
                <div class="col-md-6 col-lg-4">
                    <article class="blog-card h-100">
                        <div class="position-relative">
                            <img src="{{ $post['image'] }}" 
                                 class="w-100" alt="{{ $post['title'] }}">
                            @if($post['badge'])
                                <span class="car-card-badge" style="top: 1rem; right: 1rem; left: auto; {{ $post['badgeStyle'] }}">{{ $post['badge'] }}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <span class="carhut-chip mb-3">{{ $post['category'] }}</span>
                            <h3 class="h5 mb-3">{{ $post['title'] }}</h3>
                            <p class="text-soft mb-3">
                                @if($post['id'] == 1)
                                    Детальный обзор нового BMW X5: характеристики, тест-драйв, плюсы и минусы.
                                @elseif($post['id'] == 2)
                                    Практические советы, как найти лучшую цену и не переплатить при покупке авто.
                                @elseif($post['id'] == 3)
                                    Все об электромобилях: преимущества, недостатки, зарядка и стоимость владения.
                                @elseif($post['id'] == 4)
                                    Секреты быстрой продажи: подготовка, фото, описание и правильная цена.
                                @elseif($post['id'] == 5)
                                    Сравнение программ автокредитования, расчет переплаты и выбор оптимального варианта.
                                @else
                                    Почему регулярное ТО важно и как оно помогает сэкономить на дорогостоящих ремонтах.
                                @endif
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-soft">{{ $post['date'] }}</span>
                                <a href="#" class="text-decoration-none">Читать →</a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($blogPosts->hasPages())
            <div class="catalog-pagination">
                <div class="pagination-wrapper">
                    {{ $blogPosts->links() }}
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Newsletter Section -->
<section class="carhut-section carhut-section-light">
    <div class="container">
        <div class="cta-section">
            <h2 class="h3 mb-3 text-white">Подпишитесь на рассылку</h2>
            <p class="text-white-50 mb-4">Получайте свежие статьи и обзоры прямо на почту</p>
            <form class="row g-2 justify-content-center" style="max-width: 500px; margin: 0 auto;">
                <div class="col-auto flex-grow-1">
                    <input type="email" class="form-control" placeholder="Ваш email" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-light">Подписаться</button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
