@extends('layouts.app')
@section('title', 'Редактирование объявления :: Мои объявления')
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
                <span class="listing-form-kicker">Редактирование</span>
                <h1 class="listing-form-title">Обновите объявление и отправьте его на повторное рассмотрение</h1>
                <p class="listing-form-subtitle">
                    Категория фиксирована: только новые автомобили или автомобили с пробегом. Марка также выбирается
                    из готового списка.
                </p>

                @if ($bb->image)
                    <div class="listing-form-preview">
                        <span class="listing-form-preview-label">Текущее изображение</span>
                        <img src="{{ $bb->image_url }}" alt="{{ $bb->title }}" class="listing-form-preview-image" onerror="this.src='{{ asset('images/cars/premium-suv-bmw-x5.png') }}'">
                    </div>
                @endif
            </div>

            <form action="{{ route('bb.update', ['bb' => $bb->id]) }}" method="POST" enctype="multipart/form-data" class="listing-form-grid">
                @csrf
                @method('PATCH')

                <div class="listing-form-field">
                    <label for="txtTitle" class="listing-form-label">Название автомобиля</label>
                    <input type="text" name="title" id="txtTitle" class="listing-form-input" value="{{ old('title', $bb->title) }}" required>
                </div>

                <div class="listing-form-field">
                    <label for="txtBrand" class="listing-form-label">Марка автомобиля</label>
                    <select name="brand" id="txtBrand" class="listing-form-input" required>
                        <option value="">Выберите марку</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand }}" {{ old('brand', $bb->brand) === $brand ? 'selected' : '' }}>{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="listing-form-field">
                    <label for="txtPrice" class="listing-form-label">Цена, ₽</label>
                    <input type="number" name="price" id="txtPrice" class="listing-form-input" value="{{ old('price', $bb->price) }}" min="0" required>
                </div>

                <div class="listing-form-field">
                    <label for="txtCategory" class="listing-form-label">Категория</label>
                    <select name="category_id" id="txtCategory" class="listing-form-input" required>
                        <option value="">Выберите категорию</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ (string) old('category_id', $bb->category_id) === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="listing-form-field listing-form-field-wide">
                    <label for="txtContent" class="listing-form-label">Описание</label>
                    <textarea name="content" id="txtContent" class="listing-form-input listing-form-textarea" rows="6" required>{{ old('content', $bb->content) }}</textarea>
                </div>

                <div class="listing-form-field listing-form-field-wide">
                    <label for="txtImage" class="listing-form-label">Новая фотография автомобиля</label>
                    <input type="file" name="image" id="txtImage" class="listing-form-input listing-form-file" accept="image/png,image/jpeg,image/jpg,image/gif">
                    <div class="listing-form-help">Оставьте поле пустым, чтобы сохранить текущее изображение.</div>
                </div>

                <div class="listing-form-actions">
                    <button type="submit" class="btn carhut-btn-primary">Сохранить изменения</button>
                    <a href="{{ route('home') }}" class="btn btn-outline-light">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
