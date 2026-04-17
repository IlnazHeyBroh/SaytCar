@extends('layouts.app') 
@section('title', 'Редактирование объявления :: Мои объявления') 
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

<form action="{{ route('bb.update', ['bb' => $bb->id]) }}" method="POST" enctype="multipart/form-data"> 
 @csrf 
 @method('PATCH')
 <div class="mb-3"> 
 <label for="txtTitle" class="form-label">Название автомобиля</label> 
 <input name="title" id="txtTitle" value="{{ $bb->title }}" class="form-control" required> 
 </div> 
 <div class="mb-3"> 
 <label for="txtContent" class="form-label">Описание</label> 
 <textarea name="content" id="txtContent" class="form-control" rows="5" required>{{ $bb->content }}</textarea> 
 </div> 
 <div class="mb-3"> 
 <label for="txtPrice" class="form-label">Цена (₽)</label> 
 <input type="number" name="price" value="{{ $bb->price }}" id="txtPrice" class="form-control" required> 
 </div>
 <div class="mb-3">
 <label for="txtImage" class="form-label">Фото автомобиля</label>
 @if($bb->image)
 <div class="mb-2">
 @php
     $imageUrl = asset($bb->image);
     if (!\Illuminate\Support\Str::startsWith($bb->image, 'http')) {
         $storagePath = storage_path('app/public/cars/' . basename($bb->image));
         $publicPath = public_path($bb->image);
         if (!file_exists($storagePath) && !file_exists($publicPath)) {
            $imageUrl = asset('images/cars/premium-suv-bmw-x5.png');
         }
     }
 @endphp
 <img src="{{ $imageUrl }}" alt="Текущее фото" style="max-width: 300px; height: auto;" class="img-thumbnail" onerror="this.src='{{ asset('images/cars/premium-suv-bmw-x5.png') }}'">
 </div>
 @endif
 <input type="file" name="image" id="txtImage" class="form-control" accept="image/*">
 <small class="form-text text-muted">Оставьте пустым, чтобы сохранить текущее изображение</small>
 </div>
 <input type="submit" class="btn btn-primary" value="Сохранить"> 
</form> 
@endsection 
