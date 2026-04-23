@extends('layouts.app')
@section('title', 'Мои объявления')
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
                <h1 class="dashboard-title">Мои объявления</h1>
                <p class="dashboard-subtitle">Здесь можно посмотреть карточки, отредактировать объявление или удалить его.</p>
            </div>

            <a href="{{ route('bb.create') }}" class="btn carhut-btn-primary">Добавить объявление</a>
        </div>

        @if (count($bbs) > 0)
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

                            <div class="admin-status-row">
                                <span class="admin-badge admin-status-badge status-{{ $bb->status }}">
                                    {{ $bb->status_label }}
                                </span>
                            </div>

                            <div class="dashboard-card-actions">
                                <a href="{{ route('detail', ['bb' => $bb->id]) }}" class="btn btn-outline-light">Открыть</a>
                                <a href="{{ route('bb.edit', ['bb' => $bb->id]) }}" class="btn carhut-btn-primary">Изменить</a>
                                <a href="{{ route('bb.delete', ['bb' => $bb->id]) }}" class="btn dashboard-delete-btn">Удалить</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="dashboard-empty">
                <h2>Объявлений пока нет</h2>
                <p>Добавьте первое объявление, и оно сразу появится здесь вместе с фотографией и быстрыми действиями.</p>
                <a href="{{ route('bb.create') }}" class="btn carhut-btn-primary">Создать объявление</a>
            </div>
        @endif
    </div>
</section>

@endsection
