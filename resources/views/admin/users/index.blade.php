@extends('layouts.app')
@section('title', 'Админка · Пользователи')
@section('content')

<section class="admin-shell">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success admin-alert">{{ session('success') }}</div>
        @endif

        <div class="admin-header">
            <div>
                <span class="admin-kicker">Админка</span>
                <h1 class="admin-title">Пользователи</h1>
            </div>
            <div class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">Назад</a>
            </div>
        </div>

        <div class="admin-table-card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Объявления</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="admin-badge {{ $user->is_admin ? 'is-admin' : '' }}">
                                    {{ $user->is_admin ? 'Админ' : 'Пользователь' }}
                                </span>
                            </td>
                            <td>{{ $user->bbs_count }}</td>
                            <td class="admin-table-actions">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm carhut-btn-primary">Изменить</a>
                                @if (auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm admin-danger-btn">Удалить</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="catalog-pagination">
            <div class="pagination-wrapper">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</section>

@endsection
