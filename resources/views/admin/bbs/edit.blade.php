@extends('layouts.app')
@section('title', 'Админка · Редактирование автомобиля')
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
                <h1>Редактирование автомобиля</h1>
                <a href="{{ route('admin.bbs.index') }}">К списку</a>
            </div>
            <form action="{{ route('admin.bbs.update', $bb) }}" method="POST" enctype="multipart/form-data" class="admin-form-grid">
                @csrf
                @method('PUT')
                @include('admin.bbs._form', ['submitLabel' => 'Сохранить изменения'])
            </form>
        </div>
    </div>
</section>

@endsection
