@extends('layouts.app') 
@section('title', 'Мои объявления') 
@section('content') 

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<p class="text-end"><a href="{{ route('bb.create') }}" class="btn carhut-btn-primary">Добавить объявление</a></p> 
@if (count($bbs) > 0) 
<table class="table table-striped table-borderless"> 
    <thead> 
        <tr> 
            <th>Товар</th> 
            <th>Цена, руб.</th> 
            <th colspan="2">&nbsp;</th> 
        </tr> 
    </thead> 
    <tbody> 
        @foreach ($bbs as $bb) 
            <tr> 
                <td><h3>{{ $bb->title }}</h3></td> 
                <td>{{ $bb->price }}</td> 
                <td> 
                    <a href="{{ route('bb.edit', ['bb' => $bb->id]) }}">Изменить</a> 
                </td>
                <td> 
                <a href="{{ route('bb.delete', ['bb' => $bb->id]) }}">Удалить</a> 
                </td> 
                </tr> 
        @endforeach 
    </tbody> 
</table> 
@endif 
@endsection