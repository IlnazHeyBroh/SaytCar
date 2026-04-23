@extends('layouts.app')
@section('title', 'Админка · Категории')
@section('content')

<section class="admin-shell">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success admin-alert">{{ session('success') }}</div>
        @endif

        <div class="admin-form-card">
            <div class="admin-panel-head">
                <h1>Категории объявлений</h1>
                <a href="{{ route('admin.dashboard') }}">В админку</a>
            </div>

            <p class="admin-subtitle mb-4">Для объявлений доступны только две категории. Добавление и удаление других категорий отключено.</p>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Slug</th>
                        <th>Описание</th>
                        <th>Объявления</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ $category->bbs_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
