@extends('layouts.app')
@section('title', 'Админка · Изменить марку')
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
                <h1>Изменить марку</h1>
                <a href="{{ route('admin.brands.index') }}">К списку марок</a>
            </div>

            <form action="{{ route('admin.brands.update', $brand) }}" method="POST" class="listing-form-grid mt-4">
                @csrf
                @method('PUT')

                <div class="admin-form-wide">
                    <label for="name" class="listing-form-label">Название марки</label>
                    <input id="name" name="name" class="listing-form-input" value="{{ old('name', $brand->name) }}" required>
                </div>

                <div class="admin-form-wide admin-form-actions">
                    <button type="submit" class="btn carhut-btn-primary">Сохранить</button>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-light">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
