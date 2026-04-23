@extends('layouts.app')
@section('title', 'Админка')
@section('content')

<section class="admin-shell">
    <div class="container">
        <div class="admin-header">
            <div>
                <span class="admin-kicker">Панель управления</span>
                <h1 class="admin-title">Админка CarHut</h1>
                <p class="admin-subtitle">Управляйте пользователями, автомобилями, марками и категориями из одного места.</p>
            </div>
            <div class="admin-nav">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light">Пользователи</a>
                <a href="{{ route('admin.bbs.index') }}" class="btn btn-outline-light">Автомобили</a>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-light">Марки</a>
                <a href="{{ route('admin.categories.index') }}" class="btn carhut-btn-primary">Категории</a>
            </div>
        </div>

        <div class="admin-stats">
            <article class="admin-stat-card">
                <span>Пользователи</span>
                <strong>{{ $usersCount }}</strong>
            </article>
            <article class="admin-stat-card">
                <span>Администраторы</span>
                <strong>{{ $adminsCount }}</strong>
            </article>
            <article class="admin-stat-card">
                <span>Автомобили</span>
                <strong>{{ $carsCount }}</strong>
            </article>
            <article class="admin-stat-card">
                <span>Категории</span>
                <strong>{{ $categoriesCount }}</strong>
            </article>
            <article class="admin-stat-card">
                <span>Марки</span>
                <strong>{{ $brandsCount }}</strong>
            </article>
        </div>

        <div class="admin-grid">
            <div class="admin-panel">
                <div class="admin-panel-head">
                    <h2>Последние пользователи</h2>
                    <a href="{{ route('admin.users.index') }}">Смотреть всех</a>
                </div>
                <div class="admin-list">
                    @foreach ($latestUsers as $user)
                        <div class="admin-list-item">
                            <div>
                                <strong>{{ $user->name }}</strong>
                                <div>{{ $user->email }}</div>
                            </div>
                            <span class="admin-badge {{ $user->is_admin ? 'is-admin' : '' }}">
                                {{ $user->is_admin ? 'Админ' : 'Пользователь' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="admin-panel">
                <div class="admin-panel-head">
                    <h2>Последние автомобили</h2>
                    <a href="{{ route('admin.bbs.index') }}">Смотреть все</a>
                </div>
                <div class="admin-list">
                    @foreach ($latestCars as $bb)
                        <div class="admin-list-item">
                            <div>
                                <strong>{{ $bb->title }}</strong>
                                <div>{{ $bb->user?->name ?? 'Без владельца' }} · {{ $bb->category?->name ?? 'Без категории' }}</div>
                            </div>
                            <span>{{ number_format($bb->price, 0, ',', ' ') }} ₽</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
