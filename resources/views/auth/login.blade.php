@extends('layouts.app')
@section('title', 'Вход')
@section('content')
<section class="auth-shell">
    <div class="container auth-container">
        <div class="auth-card auth-card-login fade-in visible">
            <div class="auth-promo">
                <span class="auth-pill">CarHut Account</span>
                <h1>С возвращением</h1>
                <p>Войдите в личный кабинет, чтобы управлять объявлениями, избранным и заявками покупателей.</p>
                <ul class="auth-promo-list">
                    <li>Быстрое редактирование авто</li>
                    <li>Контроль входящих сообщений</li>
                    <li>История активности по аккаунту</li>
                </ul>
            </div>

            <div class="auth-form-wrap">
                <h2>Вход</h2>
                <p class="auth-subtitle">Введите данные аккаунта</p>

                <form method="POST" action="{{ route('login') }}" class="auth-form-grid">
                    @csrf

                    <label for="email" class="auth-label">Email</label>
                    <input id="email" type="email" class="auth-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <label for="password" class="auth-label">Пароль</label>
                    <input id="password" type="password" class="auth-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <div class="auth-actions-row">
                        <label class="auth-check">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Запомнить меня</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="auth-link" href="{{ route('password.request') }}">Забыли пароль?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn auth-submit-btn">Войти</button>
                </form>

                @if (Route::has('register'))
                    <p class="auth-bottom-note">
                        Нет аккаунта? <a class="auth-link" href="{{ route('register') }}">Создать</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
