@extends('layouts.app')
@section('title', 'Сообщения')
@section('content')

<section class="dashboard-shell">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show dashboard-alert" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="dashboard-header">
            <div>
                <span class="dashboard-kicker">Личный кабинет</span>
                <h1 class="dashboard-title">Сообщения с продавцами и покупателями</h1>
                <p class="dashboard-subtitle">Один диалог на одно объявление. Так не теряются детали по конкретной машине.</p>
            </div>
            <a href="{{ route('catalog') }}" class="btn carhut-btn-primary">Смотреть каталог</a>
        </div>

        @if ($conversations->count())
            <div class="message-list">
                @foreach ($conversations as $conversation)
                    @php
                        $isSeller = auth()->id() === $conversation->seller_id;
                        $otherUser = $isSeller ? $conversation->buyer : $conversation->seller;
                        $lastMessage = $conversation->latestMessage;
                    @endphp
                    <article class="message-list-card">
                        <a href="{{ route('messages.show', $conversation) }}" class="message-list-image-link">
                            <img src="{{ $conversation->bb->image_url }}" alt="{{ $conversation->bb->title }}" class="message-list-image">
                        </a>
                        <div class="message-list-body">
                            <div class="message-list-top">
                                <div>
                                    <div class="message-list-kicker">{{ $isSeller ? 'Покупатель' : 'Продавец' }}: {{ $otherUser?->name ?? 'Пользователь' }}</div>
                                    <h2 class="message-list-title">{{ $conversation->bb->title }}</h2>
                                </div>
                                <div class="message-list-actions">
                                    <div class="message-list-date">{{ $conversation->updated_at->format('d.m.Y H:i') }}</div>
                                    <form action="{{ route('messages.destroy', $conversation) }}" method="POST" class="inline-form" onsubmit="return confirm('Удалить этот чат? Все сообщения в нём будут удалены.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn dashboard-delete-btn btn-sm">Удалить чат</button>
                                    </form>
                                </div>
                            </div>
                            <a href="{{ route('messages.show', $conversation) }}" class="message-list-copy">
                                <p class="message-list-text">
                                    {{ $lastMessage?->body ? \Illuminate\Support\Str::limit($lastMessage->body, 120) : 'Диалог создан, но сообщений пока нет.' }}
                                </p>
                                <div class="message-list-meta">
                                    <span>{{ $conversation->bb->brand_name }}</span>
                                    @if ($conversation->bb->category)
                                        <span>{{ $conversation->bb->category->name }}</span>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="dashboard-empty">
                <h2>Диалогов пока нет</h2>
                <p>Откройте объявление и напишите продавцу, чтобы начать переписку.</p>
                <a href="{{ route('catalog') }}" class="btn carhut-btn-primary">Найти объявление</a>
            </div>
        @endif
    </div>
</section>

@endsection
