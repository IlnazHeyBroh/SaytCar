@extends('layouts.app')
@section('title', 'Добавление объявления :: Мои объявления')
@section('content')

<section class="listing-form-shell">
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger listing-form-alert" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="listing-form-card">
            <div class="listing-form-intro">
                <span class="listing-form-kicker">Новое объявление</span>
                <h1 class="listing-form-title">Добавьте автомобиль так, чтобы его захотелось открыть сразу</h1>
                <p class="listing-form-subtitle">
                    Объявление уйдёт на рассмотрение администратору. Выберите категорию и марку из готовых списков,
                    чтобы карточки были аккуратными и единообразными.
                </p>
                <div class="listing-form-note">
                    <strong>Категории:</strong> только <strong>Новые</strong> или <strong>С пробегом</strong>.
                </div>
            </div>

            <form action="{{ route('bb.store') }}" method="POST" enctype="multipart/form-data" class="listing-form-grid">
                @csrf

                <div class="listing-form-field">
                    <label for="txtTitle" class="listing-form-label">Название автомобиля</label>
                    <input type="text" name="title" id="txtTitle" class="listing-form-input" value="{{ old('title') }}" placeholder="Например, X5 2021" required>
                </div>

                <div class="listing-form-field">
                    <label for="txtBrand" class="listing-form-label">Марка автомобиля</label>
                    <select name="brand" id="txtBrand" class="listing-form-input" required>
                        <option value="">Выберите марку</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand }}" {{ old('brand') === $brand ? 'selected' : '' }}>{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="listing-form-field">
                    <label for="txtPrice" class="listing-form-label">Цена, ₽</label>
                    <input type="number" name="price" id="txtPrice" class="listing-form-input" value="{{ old('price') }}" min="0" placeholder="2500000" required>
                </div>

                <div class="listing-form-field">
                    <label for="txtCategory" class="listing-form-label">Категория</label>
                    <select name="category_id" id="txtCategory" class="listing-form-input" required>
                        <option value="">Выберите категорию</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ (string) old('category_id') === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="listing-form-field listing-form-field-wide">
                    <label for="txtContent" class="listing-form-label">Описание</label>
                    <textarea name="content" id="txtContent" class="listing-form-input listing-form-textarea" rows="6" placeholder="Опишите комплектацию, пробег, состояние кузова, обслуживание и другие важные детали" required>{{ old('content') }}</textarea>
                </div>

                <div class="listing-form-field listing-form-field-wide">
                    <label for="txtImage" class="listing-form-label">Фотография автомобиля</label>
                    <input type="file" name="image" id="txtImage" class="listing-form-input listing-form-file" accept="image/png,image/jpeg,image/jpg,image/gif">
                    <div class="listing-form-help">
                        Поддерживаются JPG, PNG и GIF до 2 МБ. Если фото не добавить, сайт покажет стандартное изображение.
                    </div>
                </div>

                <div class="listing-form-actions">
                    <button type="submit" class="btn carhut-btn-primary">Отправить объявление</button>
                    <a href="{{ route('home') }}" class="btn btn-outline-light">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
