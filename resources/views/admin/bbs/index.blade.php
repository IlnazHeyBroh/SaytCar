@extends('layouts.app')
@section('title', 'Админка · Автомобили')
@section('content')

<section class="admin-shell">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success admin-alert">{{ session('success') }}</div>
        @endif

        <div class="admin-header">
            <div>
                <span class="admin-kicker">Админка</span>
                <h1 class="admin-title">Автомобили</h1>
            </div>
            <div class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">Назад</a>
                <a href="{{ route('admin.bbs.create') }}" class="btn carhut-btn-primary">Добавить автомобиль</a>
            </div>
        </div>

        <div class="dashboard-list">
            @foreach ($bbs as $bb)
                <article class="dashboard-card">
                    <div class="dashboard-card-media">
                        <img src="{{ $bb->image_url }}" alt="{{ $bb->title }}" class="dashboard-card-image">
                    </div>
                    <div class="dashboard-card-body">
                        <div class="dashboard-card-top">
                            <div>
                                <div class="dashboard-card-brand">{{ $bb->category?->name ?? 'Без категории' }}</div>
                                <h2 class="dashboard-card-title">{{ $bb->title }}</h2>
                            </div>
                            <div class="dashboard-card-price">{{ number_format($bb->price, 0, ',', ' ') }} ₽</div>
                        </div>

                        <p class="dashboard-card-text">{{ $bb->user?->name ?? 'Без владельца' }} · {{ $bb->brand_name }}</p>

                        <div class="admin-status-row">
                            <span class="admin-badge admin-status-badge status-{{ $bb->status }}">
                                {{ $bb->status_label }}
                            </span>
                        </div>

                        <div class="dashboard-card-actions">
                            <a href="{{ route('detail', $bb) }}" class="btn btn-outline-light">Открыть</a>
                            <a href="{{ route('admin.bbs.edit', $bb) }}" class="btn carhut-btn-primary">Изменить</a>

                            @if ($bb->status !== \App\Models\Bb::STATUS_APPROVED)
                                <form action="{{ route('admin.bbs.approve', $bb) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm admin-approve-btn">Одобрить</button>
                                </form>
                            @endif

                            @if ($bb->status !== \App\Models\Bb::STATUS_REJECTED)
                                <form action="{{ route('admin.bbs.reject', $bb) }}" method="POST" onsubmit="return confirm('Отклонить это объявление? Пользователь увидит, что оно не прошло модерацию.')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm admin-reject-btn">Отклонить</button>
                                </form>
                            @endif

                            <form action="{{ route('admin.bbs.destroy', $bb) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn dashboard-delete-btn">Удалить</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="catalog-pagination">
            <div class="pagination-wrapper">
                {{ $bbs->links() }}
            </div>
        </div>
    </div>
</section>

@endsection
