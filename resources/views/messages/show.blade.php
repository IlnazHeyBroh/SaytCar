@extends('layouts.app')
@section('title', 'Диалог')
@section('content')

@php
    $isSeller = auth()->id() === $conversation->seller_id;
    $otherUser = $isSeller ? $conversation->buyer : $conversation->seller;
@endphp

<section class="dashboard-shell">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show dashboard-alert" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="message-thread-layout">
            <aside class="message-thread-sidebar">
                <a href="{{ route('messages.index') }}" class="btn btn-outline-light mb-3">← Все диалоги</a>
                <form action="{{ route('messages.destroy', $conversation) }}" method="POST" class="inline-form mb-3" onsubmit="return confirm('Удалить этот чат? Все сообщения в нём будут удалены.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn dashboard-delete-btn w-100">Удалить чат</button>
                </form>

                <div class="message-thread-card">
                    <img src="{{ $conversation->bb->image_url }}" alt="{{ $conversation->bb->title }}" class="message-thread-car-image">
                    <div class="message-thread-card-body">
                        <div class="message-thread-kicker">Объявление #{{ $conversation->bb->id }}</div>
                        <h1 class="message-thread-title">{{ $conversation->bb->title }}</h1>
                        <div class="message-thread-price">{{ number_format($conversation->bb->price, 0, ',', ' ') }} ₽</div>
                        <div class="message-thread-meta">
                            <span>{{ $conversation->bb->brand_name }}</span>
                            @if ($conversation->bb->category)
                                <span>{{ $conversation->bb->category->name }}</span>
                            @endif
                        </div>
                        <div class="message-thread-partner">
                            <strong>{{ $isSeller ? 'Покупатель' : 'Продавец' }}:</strong>
                            <span>{{ $otherUser?->name ?? 'Пользователь' }}</span>
                        </div>
                        <a href="{{ route('detail', $conversation->bb) }}" class="btn carhut-btn-primary w-100">Открыть объявление</a>
                    </div>
                </div>
            </aside>

            <div class="message-thread-main">
                <div class="message-thread-box">
                    <div class="message-thread-header">
                        <div>
                            <div class="message-thread-kicker">Диалог по объявлению</div>
                            <h2 class="message-thread-heading">{{ $conversation->bb->title }}</h2>
                        </div>
                        <div class="message-thread-date">{{ $conversation->updated_at->format('d.m.Y H:i') }}</div>
                    </div>

                    <div class="message-thread-messages">
                        @forelse ($conversation->messages->sortBy('created_at') as $message)
                            <div class="message-bubble {{ $message->user_id === auth()->id() ? 'is-own' : '' }}">
                                <div class="message-bubble-author">{{ $message->user?->name ?? 'Пользователь' }}</div>
                                <div class="message-bubble-text">{{ $message->body }}</div>
                                <div class="message-bubble-date">{{ $message->created_at->format('d.m.Y H:i') }}</div>
                            </div>
                        @empty
                            <div class="message-empty">Сообщений пока нет. Начните диалог первым.</div>
                        @endforelse
                    </div>

                    <form action="{{ route('messages.send', $conversation) }}" method="POST" class="message-compose">
                        @csrf
                        <textarea
                            name="body"
                            rows="4"
                            class="form-control message-compose-textarea"
                            placeholder="Введите сообщение"
                        >{{ old('body') }}</textarea>
                        <button type="submit" class="btn carhut-btn-primary">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
