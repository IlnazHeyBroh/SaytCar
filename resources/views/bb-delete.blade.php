@extends('layouts.app')
@section('title', 'Удаление объявления :: Мои объявления')
@section('content')

<section class="delete-shell">
    <div class="container">
        <div class="delete-card">
            <div class="delete-copy">
                <span class="delete-kicker">Подтверждение удаления</span>
                <h1 class="delete-title">Удалить это объявление?</h1>
                <p class="delete-subtitle">
                    Объявление будет удалено вместе с загруженной фотографией. Это действие нельзя отменить.
                </p>

                <div class="delete-meta">
                    <div class="delete-meta-item">
                        <span>Автомобиль</span>
                        <strong>{{ $bb->title }}</strong>
                    </div>
                    <div class="delete-meta-item">
                        <span>Цена</span>
                        <strong>{{ number_format($bb->price, 0, ',', ' ') }} ₽</strong>
                    </div>
                </div>

                <form action="{{ route('bb.destroy', ['bb' => $bb->id]) }}" method="POST" class="delete-actions">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger delete-confirm-btn">Удалить объявление</button>
                    <a href="{{ route('home') }}" class="btn btn-outline-light">Вернуться назад</a>
                </form>
            </div>

            <div class="delete-preview">
                <img
                    src="{{ $bb->image_url }}"
                    alt="{{ $bb->title }}"
                    class="delete-preview-image"
                    onerror="this.src='{{ asset('images/cars/premium-suv-bmw-x5.png') }}'"
                >
            </div>
        </div>
    </div>
</section>

@endsection
