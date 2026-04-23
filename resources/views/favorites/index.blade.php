@extends('layouts.app')
@section('title', 'Избранное')
@section('content')

<section class="dashboard-shell">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show dashboard-alert" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="dashboard-header">
            <div>
                <span class="dashboard-kicker">Личный кабинет</span>
                <h1 class="dashboard-title">Избранные объявления</h1>
                <p class="dashboard-subtitle">Сохраняйте интересные машины в один список и возвращайтесь к ним позже.</p>
            </div>
            <a href="{{ route('catalog') }}" class="btn carhut-btn-primary">Перейти в каталог</a>
        </div>

        @if ($bbs->count())
            <div class="dashboard-list">
                @foreach ($bbs as $bb)
                    <article class="dashboard-card">
                        <a href="{{ route('detail', ['bb' => $bb->id]) }}" class="dashboard-card-media">
                            <img
                                src="{{ $bb->image_url }}"
                                alt="{{ $bb->title }}"
                                class="dashboard-card-image"
                                onerror="this.src='{{ asset('images/cars/premium-suv-bmw-x5.png') }}'"
                            >
                        </a>

                        <div class="dashboard-card-body">
                            <div class="dashboard-card-top">
                                <div>
                                    <div class="dashboard-card-brand">
                                        {{ $bb->category?->name ?? $bb->brand_name }}
                                    </div>
                                    <h2 class="dashboard-card-title">{{ $bb->title }}</h2>
                                </div>
                                <div class="dashboard-card-price">{{ number_format($bb->price, 0, ',', ' ') }} ₽</div>
                            </div>

                            <p class="dashboard-card-text">{{ $bb->short_description }}</p>

                            <div class="favorite-meta-line">
                                <span>Продавец: {{ $bb->user?->name ?? 'Не указан' }}</span>
                                <span>Марка: {{ $bb->brand_name }}</span>
                            </div>

                            <div class="dashboard-card-actions">
                                <a href="{{ route('detail', ['bb' => $bb->id]) }}" class="btn btn-outline-light">Открыть</a>
                                @if (auth()->id() !== $bb->user_id)
                                    <form action="{{ route('messages.store', $bb) }}" method="POST" class="inline-form">
                                        @csrf
                                        <input type="hidden" name="body" value="Здравствуйте! Интересует ваше объявление «{{ $bb->title }}». Подскажите, оно еще актуально?">
                                        <button type="submit" class="btn carhut-btn-primary">Написать продавцу</button>
                                    </form>
                                @endif
                                <form action="{{ route('favorites.destroy', $bb) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn dashboard-delete-btn">Убрать</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="dashboard-empty">
                <h2>Пока нет избранных объявлений</h2>
                <p>Добавляйте интересные автомобили в избранное, и они появятся здесь.</p>
                <a href="{{ route('catalog') }}" class="btn carhut-btn-primary">Найти автомобиль</a>
            </div>
        @endif
    </div>
</section>

@endsection
