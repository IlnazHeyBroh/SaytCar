@extends('layouts.app') 
@section('title', 'Добавление объявления :: Мои объявления') 
@section('content') 

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('bb.store') }}" method="POST" enctype="multipart/form-data"> 
 @csrf 
 <div class="mb-3"> 
 <label for="txtTitle" class="form-label">Название автомобиля</label> 
 <input name="title" id="txtTitle" class="form-control" required> 
 </div> 
 <div class="mb-3"> 
 <label for="txtContent" class="form-label">Описание</label> 
 <textarea name="content" id="txtContent" class="form-control" rows="5" required></textarea> 
 </div> 
 <div class="mb-3"> 
 <label for="txtPrice" class="form-label">Цена (₽)</label> 
 <input type="number" name="price" id="txtPrice" class="form-control" required> 
 </div>
 <div class="mb-3">
 <label for="txtImage" class="form-label">Фото автомобиля</label>
 <input type="file" name="image" id="txtImage" class="form-control" accept="image/*">
 <small class="form-text text-muted">Загрузите изображение автомобиля</small>
 </div>
 <input type="submit" class="btn btn-primary" value="Добавить"> 
</form> 
@endsection 