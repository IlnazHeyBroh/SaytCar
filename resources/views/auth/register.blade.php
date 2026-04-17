@extends('layouts.app')
@section('title', 'Регистрация')
@section('content')
<section class="auth-shell">
    <div class="container auth-container">
        <div class="auth-card auth-card-register fade-in visible">
            <div class="auth-promo">
                <span class="auth-pill">Join CarHut</span>
                <h1>Создайте аккаунт</h1>
                <p>После регистрации вы сможете размещать объявления, сохранять подборки и получать уведомления о новых предложениях.</p>
                <ul class="auth-promo-list">
                    <li>Публикация авто за пару минут</li>
                    <li>Управление объявлением в одном месте</li>
                    <li>Быстрый контакт с покупателями</li>
                </ul>
            </div>

            <div class="auth-form-wrap">
                <h2>Регистрация</h2>
                <p class="auth-subtitle">Заполните данные для нового профиля</p>

                <form method="POST" action="{{ route('register') }}" class="auth-form-grid">
                    @csrf

                    <label for="name" class="auth-label">Имя</label>
                    <input id="name" type="text" class="auth-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <label for="email" class="auth-label">Email</label>
                    <input id="email" type="email" class="auth-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <label for="password" class="auth-label">Пароль</label>
                    <input id="password" type="password" class="auth-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <label for="password-confirm" class="auth-label">Подтверждение пароля</label>
                    <input id="password-confirm" type="password" class="auth-input" name="password_confirmation" required autocomplete="new-password">

                    <button type="submit" class="btn auth-submit-btn">Создать аккаунт</button>
                </form>

                @if (Route::has('login'))
                    <p class="auth-bottom-note">
                        Уже есть аккаунт? <a class="auth-link" href="{{ route('login') }}">Войти</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
