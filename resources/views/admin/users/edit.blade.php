@extends('layouts.app')
@section('title', 'Админка · Редактирование пользователя')
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
                <h1>Редактирование пользователя</h1>
                <a href="{{ route('admin.users.index') }}">К списку</a>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="admin-form-grid">
                @csrf
                @method('PUT')

                <div>
                    <label class="listing-form-label" for="userName">Имя</label>
                    <input id="userName" name="name" class="listing-form-input" value="{{ old('name', $user->name) }}" required>
                </div>

                <div>
                    <label class="listing-form-label" for="userEmail">Email</label>
                    <input id="userEmail" type="email" name="email" class="listing-form-input" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="admin-form-wide">
                    <label class="admin-checkbox">
                        <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }} {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                        <span>Выдать права администратора</span>
                    </label>
                    @if (auth()->id() === $user->id)
                        <div class="listing-form-help">Свою админ-роль система не даёт снять из этой формы.</div>
                    @endif
                </div>

                <div>
                    <label class="listing-form-label" for="password">Новый пароль</label>
                    <input id="password" type="password" name="password" class="listing-form-input">
                </div>

                <div>
                    <label class="listing-form-label" for="password_confirmation">Подтверждение пароля</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="listing-form-input">
                </div>

                <div class="admin-form-wide admin-form-actions">
                    <button type="submit" class="btn carhut-btn-primary">Сохранить</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
