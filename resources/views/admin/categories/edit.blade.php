@extends('layouts.app')
@section('title', 'Админка · Редактирование категории')
@section('content')

<section class="admin-shell">
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger admin-alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-form-card">
            <div class="admin-panel-head">
                <h1>Редактирование категории</h1>
                <a href="{{ route('admin.categories.index') }}">К списку</a>
            </div>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="admin-form-grid">
                @csrf
                @method('PUT')
                <div>
                    <label class="listing-form-label" for="name">Название</label>
                    <input id="name" name="name" class="listing-form-input" value="{{ old('name', $category->name) }}" required>
                </div>
                <div>
                    <label class="listing-form-label" for="slug">Slug</label>
                    <input id="slug" name="slug" class="listing-form-input" value="{{ old('slug', $category->slug) }}">
                </div>
                <div class="admin-form-wide">
                    <label class="listing-form-label" for="description">Описание</label>
                    <textarea id="description" name="description" class="listing-form-input listing-form-textarea" rows="5">{{ old('description', $category->description) }}</textarea>
                </div>
                <div class="admin-form-wide admin-form-actions">
                    <button type="submit" class="btn carhut-btn-primary">Сохранить</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
