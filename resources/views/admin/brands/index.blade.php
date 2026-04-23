@extends('layouts.app')
@section('title', 'Админка · Марки')
@section('content')

<section class="admin-shell">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success admin-alert">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger admin-alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-form-card mb-4">
            <div class="admin-panel-head">
                <h1>Марки автомобилей</h1>
                <a href="{{ route('admin.dashboard') }}">В админку</a>
            </div>

            <p class="admin-subtitle mb-4">Добавляйте новые бренды, чтобы они появились в формах создания и редактирования объявлений.</p>

            <form action="{{ route('admin.brands.store') }}" method="POST" class="admin-inline-form">
                @csrf
                <input type="text" name="name" class="listing-form-input" placeholder="Например, Suzuki" value="{{ old('name') }}" required>
                <button type="submit" class="btn carhut-btn-primary">Добавить марку</button>
            </form>
        </div>

        <div class="admin-form-card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Марка</th>
                        <th>Slug</th>
                        <th>Объявления</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                        <tr>
                            <td>{{ $brand->name }}</td>
                            <td>{{ $brand->slug }}</td>
                            <td>{{ $brand->cars_count }}</td>
                            <td class="admin-actions-cell">
                                <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm carhut-btn-primary">Изменить</a>
                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline-form" onsubmit="return confirm('Удалить эту марку?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm dashboard-delete-btn">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
